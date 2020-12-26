<?php


class Router
{
    private $routes = [];

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /*
     * Возвращает URI текущий
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function execute()
    {
        $uri = $this->getURI();
        //Проходимся по роутам загруженным из папки config/routes.php
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                //Если нашли параметры, то подставляем их в путь на место $цифра
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                //Делем на сегменты
                $segments = explode('/', $internalRoute);

                //Конвертируем первый сегмент в название контроллера и удаляем из массива
                $controllerName = ucfirst(array_shift($segments)) . "Controller";

                //Конвертируем второй сегмент в название экшена и удаляем из массива
                $actionName = 'action' . ucfirst(array_shift($segments));

                //Получаем путь к файлу контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                //Вытащили action и controller, остались лишь параметры
                $parameters = $segments;

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                //Создаём объект контроллера
                $controllerObject = new $controllerName;

                //В результат отдаётся вызов экшена из контроллера, и передаются в него параметры
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }

}