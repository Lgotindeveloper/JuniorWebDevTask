<?php

include_once ROOT . '/models/UsersModel.php';

class UsersController
{
    /*
     * Просмотр загруженных пользователей из БД
     */
    public function actionDbShow()
    {
        $action = "load_from_db";
        $users = UsersModel::getAllDBUsers();
        $userCounter = 1;

        foreach ($users as $user) {
            $date = $user['registered_at'];
            $monthes = [
                '01' => 'января',
                '02' => 'февраля',
                '03' => 'марта',
                '04' => 'апреля',
                '05' => 'мая',
                '06' => 'июня',
                '07' => 'июля',
                '08' => 'августа',
                '09' => 'сентября',
                '10' => 'октября',
                '11' => 'ноября',
                '12' => 'декабря',
            ];
            $month = $monthes[$user['registered_at']->format('m')];
        }

        require_once(ROOT . "/views/users/index.php");
    }

    /*
     * Просмотр загруженных пользователей из файла
     */
    public function actionFileShow()
    {
        $action = "load_from_file";
        $users = UsersModel::getAllFileUsers();
        $userCounter = 1;

        foreach ($users as $user) {
            $date = $user['registered_at'];
            $monthes = [
                '01' => 'января',
                '02' => 'февраля',
                '03' => 'марта',
                '04' => 'апреля',
                '05' => 'мая',
                '06' => 'июня',
                '07' => 'июля',
                '08' => 'августа',
                '09' => 'сентября',
                '10' => 'октября',
                '11' => 'ноября',
                '12' => 'декабря',
            ];
            $month = $monthes[$user['registered_at']->format('m')];
        }

        require_once(ROOT . "/views/users/index.php");
    }

    /*
     * Удаляет юзера по уникальному id и
     * делает редирект обратно на просмотр пользователей загруженных из БД
     */
    public function actionDBUserDelete($uuid)
    {
        UsersModel::deleteDBUserById($uuid);

        $redirect_url = "/users/db/show";
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $redirect_url);
    }

    /*
     * Удаляет юзера по уникальному id и
     * делает редирект обратно на просмотр пользователей загруженных из ФАЙЛА
     */
    public function actionFileUserDelete($uuid)
    {
        UsersModel::deleteFileUserById($uuid);

        $redirect_url = "/users/file/show";
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $redirect_url);
    }

    /*
     * Генерирует данные в БД и
     * делает редирект на просмотр пользователей загруженных из БД
     */
    public function actionDBGenerate()
    {
        UsersModel::generateDBUsers(6);

        $redirect_url = "/users/db/show";
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $redirect_url);
    }

    /*
     * Генерирует данные в ФАЙЛЕ и
     * делает редирект на просмотр пользователей загруженных из ФАЙЛА
     */
    public function actionFileGenerate()
    {
        UsersModel::generateFileUsers(4);

        $redirect_url = "/users/file/show";
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $redirect_url);
    }
}