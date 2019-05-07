<?php
return array(
    "/books" => [
    "controller" => "UserController",
    "methods" => [
        "get" => "getBooks",
        "post" => "addBook"
    ],
    "sub-url" => [
        "/{user_id}" => [
            "methods" => [
                "put" => "updateUser",
                "get" => "getUser"
            ]
            ,"sub-url" => [
                ]
        ]
    ]
  ],
  "/home/promo" => [
    "controller" => "HomeController",
    "methods" => [
        "get" => "getPromos"
    ]
  ]
);