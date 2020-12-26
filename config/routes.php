<?php

return [
    "users/db/show" => "users/dbshow", //url: yoursite/users/showdb -> UsersController, actionShowdb
    "users/file/show" => "users/fileshow",
    "users/db/delete/([0-9]+)" => "users/dbuserdelete/$1",
    "users/file/delete/([0-9]+)" => "users/fileuserdelete/$1",
    "users/db/generate" => "users/dbgenerate",
    "users/file/generate" => "users/filegenerate",
];