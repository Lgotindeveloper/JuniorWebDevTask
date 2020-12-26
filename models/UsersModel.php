<?php


require_once(ROOT . "/components/Cache.php");
require_once(ROOT . "/components/Logger.php");
require_once(ROOT . "/components/Db.php");

class UsersModel
{
    /*
     * Возвращает всех пользователей имеющихся в базе данных
     */
    public static function getAllDBUsers()
    {
        $logger = new Logger();
        $pdo = Db::getConnection();

        $users = Cache::get('db');

        if ($users === null) {
            foreach ($pdo->query('SELECT * FROM users')->fetchAll() as $row) {
                $users[$row['uuid']] = [
                    'uuid' => $row['uuid'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'location' => json_decode($row['address'], true),
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'registered_at' => date_create($row['registered_at']),
                ];
            }
            if (!$users) {
                $users = [];
            }

            Cache::set('db', $users);
            $logger->log('Load from db');
        } else {
            $logger->log('Load from cache');
        }

        return $users;
    }

    /*
     * Возвращает всех пользователей имеющихся в файле, если файла нет,
     * то создаёт фаил
     */
    public static function getAllFileUsers()
    {
        $logger = new Logger();
        $logger->log("Load from file");

        $usersFilePath = ROOT . '/users';

        $users = [];

        if (file_exists($usersFilePath)) {
            $users = unserialize(file_get_contents(ROOT . '/users'));
        }

        return $users;
    }

    /*
     * Удаляет пользователя в базе данных по уникальному айдишнику
     */
    public static function deleteDBUserById($uuid)
    {
        $pdo = Db::getConnection();
        $logger = new Logger();

        $pdo->exec('DELETE FROM users WHERE uuid = "' . $uuid . '"');

        Cache::reset("db");

        $logger->log("User in db deleted");
    }

    /*
     * Удаляет пользователя в файле по его уникальному айдишнику
     */
    public static function deleteFileUserById($uuid)
    {
        $users = unserialize(file_get_contents('users'));
        $logger = new Logger();

        unset($users[$uuid]);
        file_put_contents(ROOT . '/users', serialize($users));

        $logger->log("User in file deleted");
    }

    /*
     * Генерирует пользователей в базе данных
     */
    public static function generateDBUsers($countUsers = 5)
    {
        $pdo = Db::getConnection();
        $logger = new Logger();

        $users = self::getUsersData($countUsers);

        self::clearUsersDb();

        foreach ($users as $uuid => $user) {
            $serializedLocation = json_encode($user['location']);
            $pdo->exec("INSERT INTO users (uuid, first_name, last_name, email, phone, address, registered_at) 
            VALUES (
            '$uuid',
            '{$user['first_name']}',
            '{$user['last_name']}',
            '{$user['email']}',
            '{$user['phone']}',
            '{$serializedLocation}',
            '{$user['registered_at']->format('Y-m-d H:i:s')}'
        )");
        }

        Cache::reset('db');

        $logger->log('Fill db');
    }

    /*
     * Генерирует пользователей в файле
     */
    public static function generateFileUsers($countUsers = 5)
    {
        $users = self::getUsersData($countUsers);
        $logger = new Logger();

        file_put_contents(ROOT . '/users', serialize($users));

        $logger->log("Fill file");
    }

    /*
     * При вызове возвращает массив сгенерированных пользователей
     * Принимаем аргумент: кол-во сгенерированных юзеров
     */
    public static function getUsersData($countUsers = 5)
    {
        $users = [];

        foreach (json_decode(file_get_contents("https://randomuser.me/api/?results=$countUsers&nat=gb"), true)['results'] as $data) {
            $uuid = uniqid();
            $users[$uuid] = [
                'uuid' => $uuid,
                'first_name' => $data['name']['first'],
                'last_name' => $data['name']['last'],
                'location' => $data['location'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registered_at' => date_create($data['registered']['date']),
            ];
        }

        return $users;
    }

    /*
     * Очищает таблицу users
     */
    public static function clearUsersDb()
    {
        $pdo = Db::getConnection();
        $pdo->exec('DELETE FROM users');
    }
}