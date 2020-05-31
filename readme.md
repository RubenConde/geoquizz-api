<p  align="center"><img title="GéoQuizz Logo" src="https://res.cloudinary.com/dxskfxwwo/image/upload/v1558424889/icons/world_kpar67.png" alt="GéoQuizz Logo"></p>


- [About GéoQuizz API](#about-g%C3%A9oquizz-api)
  - [Authentication](#authentication)
    - [Endpoints](#endpoints)
      - [`/register`](#register)
      - [`/login`](#login)
      - [`/logout`](#logout)
      - [`/user`](#user)
  - [Games](#games)
    - [Table information](#table-information)
    - [Endpoints](#endpoints-1)
      - [`/games`](#games)
      - [`/games/:id`](#gamesid)
  - [Difficulties](#difficulties)
    - [Table information](#table-information-1)
    - [Endpoints](#endpoints-2)
      - [`/difficulties`](#difficulties)
      - [`/difficulties/:id`](#difficultiesid)
  - [Series](#series)
    - [Table information](#table-information-2)
    - [Endpoints](#endpoints-3)
      - [`/series`](#series)
      - [`/series/:id`](#seriesid)
  - [Photos](#photos)
    - [Table information](#table-information-3)
    - [Endpoints](#endpoints-4)
      - [`/photos`](#photos)
      - [`/photos/:id`](#photosid)
- [Notes](#notes)
- [License](#license)

# About GéoQuizz API

The idea of GéoQuizz API comes from a school project in which the objective is to feed a game where users could select a specific place to then get photos of important sites of it and locate them on a map. This API is created mainly for this reason, however, the structure of it can be used as a basis for future projects.

GéoQuizz API is a RESTful API for the consumption of the game of the same name, made mainly in PHP using the [Laravel framework](https://laravel.com/) in its version 5.8. The structure of the GeoQuizz API database is MySQL, in the section of each table you can see the information concerning it as well as its fields.

At the moment the project is hosted on the [Heroku](https://www.heroku.com/) server, in the future will be launched on a server of its own. The basic structure of the url is:

<p align="center">
<code>https://geoquizz-api.herokuapp.com/api/v1/:endpoint</code>
</p>

## Authentication

### Endpoints

#### `/register`

Endpoint to register a new user

-   #### Method
    `POST`
-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `name` `email` `password` `password_confirmation`
    -   ##### Optional:
        `...`
-   #### Headers
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Success Response:
    -   ##### `200 OK`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Registration completed successfully",
            "data": {
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSU..."
            }
        }
        ```
-   #### Error Response:
    -   ##### `400 Bad Request`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error!",
            "errors": {
                "name": [
                    "The name may not be greater than 255 characters.",
                    "The name field is required."
                ],
                "email": [
                    "The email may not be greater than 255 characters.",
                    "The email has already been taken.",
                    "The email must be a valid email address.",
                    "The email field is required."
                ],
                "password": [
                    "The password must be at least 8 characters.",
                    "The password confirmation does not match.",
                    "The password field is required."
                ]
            }
        }
        ```

#### `/login`

Endpoint to log in to the system

-   #### Method
    `POST`
-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `email` `password`
    -   ##### Optional:
        `...`
-   #### Headers
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Success Response:
    -   ##### `200 OK`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Logged successfully",
            "data": {
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSU..."
            }
        }
        ```
-   #### Error Response:
    -   ##### `422 Unprocessable Entity`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 422,
            "message": "User does not exist"
        }
        ```
    -   ##### `422 Unprocessable Entity`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 422,
            "message": "Password missmatch"
        }
        ```

#### `/logout`

Endpoint to log out of the system

-   #### Methods
    `GET`
-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Headers
    -   ##### Required:
        `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`
    -   ##### Optional:
        `...`
-   #### Success Response:
    -   ##### `200 OK`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "You have been successfully logged out!",
            "data": ""
        }
        ```
-   #### Error Response:
    -   ##### `401 Unauthorized`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

#### `/user`

Endpoint to get information from the logged-in user

-   #### Methods
    `GET`
-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Headers
    -   ##### Required:
        `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`
    -   ##### Optional:
        `...`
-   #### Success Response:
    -   ##### `200 OK`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "User obtained",
            "data": {
                "id": 12,
                "name": "Admin",
                "email": "admin@mail.com",
                "email_verified_at": null,
                "created_at": "2019-05-20 05:17:22",
                "updated_at": "2019-05-20 05:17:22"
            }
        }
        ```
-   #### Error Response:
    -   ##### `401 Unauthorized`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

## Games

### Table information

| Field        | Type    | Description                                                                               |
| ------------ | ------- | ----------------------------------------------------------------------------------------- |
| id           | integer | Game identifier                                                                           |
| player       | string  | Name of the player                                                                        |
| status       | integer | Game status _`0 = completed` `1 = started` `2 = completed but not visible in scoreboard`_ |
| score        | integer | Game score                                                                                |
| idSeries     | integer | Identifier of the series to which it belongs                                              |
| idDifficulty | integer | Identifier of the difficulty to which it belongs                                          |

### Endpoints

#### `/games`

-   #### Methods

    `GET` <small>Endpoint for a list of games registered in the database</small>

    `POST` <small>Endpoint to register a new game in the database</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        -   ##### `page = [numeric] | default = 1`
            <small>_Used to specify the page number you want to access._</small>
        -   ##### `limit = [numeric] | default = 25`
            <small>_Used to specify the maximum number of elements on a page of the answer._</small>
        -   ##### `fields = [alphanumeric] | default = id,player`
            <small>_Used to specify the fields to get from the list items, it will give one of them separated by a comma._</small>
        -   ##### `sort = [alphabetic] | default = id`
            <small>_Used to specify a field by which to sort items in the list._</small>
        -   ##### `order = [alphabetic] | default = asc`
            <small>_Used to specify a direction by which to sort items in the list._</small>
        -   ##### `filter = [alphanumeric] | default = null`
            <small>_Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`_</small>
-   #### Data Params
    -   ##### Required:
        `player` `idSeries` `idDifficulty`
    -   ##### Optional:
        `status` `score`
-   #### Headers
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Success Response:
    -   ##### `201 Created (POST)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Game created successfully.",
            "data": {
                "id": 51,
                "status": 2,
                "score": 1000,
                "player": "NebruEdnco",
                "idSeries": 1,
                "idDifficulty": 1,
                "created_at": "2019-05-20 07:33:44",
                "updated_at": "2019-05-20 07:33:44"
            }
        }
        ```
    -   ##### `206 Partial Content (GET)`
        ```json
        {
            "success": true,
            "type": "collection",
            "message": "Games retrieved successfully.",
            "data": {
                "count": 25,
                "games": [
                    {
                        "game": {
                            "id": 1,
                            "player": "Raegan Carter"
                        },
                        "links": {
                            "self": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/games/1"
                            }
                        }
                    },
                    {
                        "...": "..."
                    }
                ],
                "links": {
                    "prev": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/games?page=1"
                    },
                    "next": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/games?page=2"
                    },
                    "first": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/games?page=1"
                    },
                    "last": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/games?page=3"
                    }
                }
            }
        }
        ```
-   #### Error Response:
    -   ##### `400 Bad Request (POST)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "status": [
                    "The status must be a number.",
                    "The status must be between 0 and 2."
                ],
                "score": ["The score must be a number."],
                "player": ["The player field is required."],
                "idSeries": [
                    "The id series must be a number.",
                    "The id series field is required.",
                    "The selected id series is invalid."
                ],
                "idDifficulty": [
                    "The id difficulty must be a number.",
                    "The id difficulty field is required.",
                    "The selected id difficulty is invalid."
                ]
            }
        }
        ```

#### `/games/:id`

-   #### Methods

    `GET` <small>Endpoint to get information about a specific game</small>

    `PUT` <small>Endpoint to update the information of a specific game</small>

    `DELETE` <small>Endpoint to remove a specific game</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `status` `score` `player` `idSeries` `idDifficulty`
-   #### Headers

    -   ##### Required:

        -   `DELETE`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:

    -   ##### `200 OK (GET)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Game retrieved successfully.",
            "data": {
                "game": {
                    "id": 25,
                    "status": 1,
                    "score": 272581,
                    "player": "Dahlia Williamson",
                    "idSeries": 38,
                    "idDifficulty": 17,
                    "created_at": "2019-05-05 09:09:38",
                    "updated_at": "2019-05-05 09:09:38",
                    "series": [
                        {
                            "series": {
                                "id": 38,
                                "city": "North Madilyn"
                            },
                            "links": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/series/38"
                            }
                        }
                    ],
                    "difficulties": [
                        {
                            "difficulty": {
                                "id": 17,
                                "name": "Kamille Greenfelder"
                            },
                            "links": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/series/17"
                            }
                        }
                    ],
                    "links": {
                        "self": {
                            "href": "https://geoquizz-api.herokuapp.com/api/v1/games/25"
                        }
                    }
                }
            }
        }
        ```
    -   ##### `200 OK (PUT)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Game updated successfully.",
            "data": {
                "id": 25,
                "status": "2",
                "score": "9999",
                "player": "NebruEdnco",
                "idSeries": "1",
                "idDifficulty": "1",
                "created_at": "2019-05-05 09:09:38",
                "updated_at": "2019-05-20 13:39:45"
            }
        }
        ```
    -   ##### `204 No Content (DELETE)`

        ```json

        ```

-   #### Error Response:

    -   ##### `400 Bad Request (PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "status": [
                    "The status must be a number.",
                    "The status must be between 0 and 2."
                ],
                "score": ["The score must be a number."],
                "player": ["The player field must have a value."],
                "idSeries": [
                    "The id series must be a number.",
                    "The selected id series is invalid."
                ],
                "idDifficulty": [
                    "The id difficulty must be a number.",
                    "The selected id difficulty is invalid."
                ]
            }
        }
        ```

    -   ##### `401 Unauthorized (DELETE)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

    -   ##### `404 Not Found (GET | PUT | DELETE)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 404,
            "message": "Information not found for: https://geoquizz-api.herokuapp.com/api/v1/games/50"
        }
        ```

## Difficulties

### Table information

| Field          | Type    | Description                                         |
| -------------- | ------- | --------------------------------------------------- |
| id             | integer | Difficulty identifier                               |
| name           | string  | Name of the difficulty                              |
| distance       | float   | Distance of between the place and the user position |
| numberOfPhotos | integer | Quantity of photos to show                          |

### Endpoints

#### `/difficulties`

-   #### Methods

    `GET` <small>Endpoint for a list of difficulties registered in the database</small>

    `POST` <small>Endpoint to register a new difficulty in the database</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        -   ##### `page = [numeric] | default = 1`
            <small>_Used to specify the page number you want to access._</small>
        -   ##### `limit = [numeric] | default = 25`
            <small>_Used to specify the maximum number of elements on a page of the answer._</small>
        -   ##### `fields = [alphanumeric] | default = id,name`
            <small>_Used to specify the fields to get from the list items, it will give one of them separated by a comma._</small>
        -   ##### `sort = [alphabetic] | default = id`
            <small>_Used to specify a field by which to sort items in the list._</small>
        -   ##### `order = [alphabetic] | default = asc`
            <small>_Used to specify a direction by which to sort items in the list._</small>
        -   ##### `filter = [alphanumeric] | default = null`
            <small>_Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`_</small>
-   #### Data Params
    -   ##### Required:
        `name` `distance` `numberOfPhotos`
    -   ##### Optional:
        `...`
-   #### Headers

    -   ##### Required:

        -   `POST`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:
    -   ##### `201 Created (POST)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Difficulty created successfully.",
            "data": {
                "id": 51,
                "name": "Hard",
                "distance": 1000,
                "numberOfPhotos": 10,
                "created_at": "2019-05-21 06:04:18",
                "updated_at": "2019-05-21 06:04:18"
            }
        }
        ```
    -   ##### `206 Partial Content (GET)`
        ```json
        {
            "success": true,
            "type": "collection",
            "message": "Difficulties retrieved successfully.",
            "data": {
                "count": 25,
                "difficulties": [
                    {
                        "difficulty": {
                            "id": 1,
                            "name": "Roscoe Rempel"
                        },
                        "links": {
                            "self": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties/1"
                            }
                        }
                    },
                    {
                        "...": "..."
                    }
                ],
                "links": {
                    "prev": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties?page=1"
                    },
                    "next": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties?page=2"
                    },
                    "first": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties?page=1"
                    },
                    "last": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties?page=2"
                    }
                }
            }
        }
        ```
-   #### Error Response:

    -   ##### `400 Bad Request (POST)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "name": ["The name field is required."],
                "distance": [
                    "The distance field is required.",
                    "The distance must be a number."
                ],
                "numberOfPhotos": [
                    "The number of photos field is required.",
                    "The number of photos must be a number."
                ]
            }
        }
        ```
    -   ##### `401 Unauthorized (POST)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

#### `/difficulties/:id`

-   #### Methods

    `GET` <small>Endpoint to get information about a specific difficulty</small>

    `PUT` <small>Endpoint to update the information of a specific difficulty</small>

    `DELETE` <small>Endpoint to remove a specific difficulty</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `name` `distance` `numberOfPhotos`
-   #### Headers

    -   ##### Required:

        -   `DELETE | PUT`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:

    -   ##### `200 OK (GET)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Difficulty retrieved successfully.",
            "data": {
                "difficulty": {
                    "id": 25,
                    "name": "Nya Carter",
                    "distance": 123,
                    "numberOfPhotos": 81,
                    "created_at": "2019-05-05 09:09:37",
                    "updated_at": "2019-05-05 09:09:37",
                    "games": [
                        {
                            "game": {
                                "id": 29,
                                "player": "Delphia Skiles DDS"
                            },
                            "href": "https://geoquizz-api.herokuapp.com/api/v1/games/29"
                        }
                    ],
                    "links": {
                        "self": {
                            "href": "https://geoquizz-api.herokuapp.com/api/v1/difficulties/25"
                        }
                    }
                }
            }
        }
        ```
    -   ##### `200 OK (PUT)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Difficulty updated successfully.",
            "data": {
                "id": 25,
                "name": "SuperHard",
                "distance": "10",
                "numberOfPhotos": "5",
                "created_at": "2019-05-05 09:09:37",
                "updated_at": "2019-05-21 06:10:08"
            }
        }
        ```
    -   ##### `204 No Content (DELETE)`

        ```json

        ```

-   #### Error Response:

    -   ##### `400 Bad Request (PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "name": ["The name field must have a value."],
                "distance": ["The distance must be a number."],
                "numberOfPhotos": ["The number of photos must be a number."]
            }
        }
        ```

    -   ##### `401 Unauthorized (DELETE | PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

    -   ##### `404 Not Found (GET | PUT | DELETE)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 404,
            "message": "Information not found for: https://geoquizz-api.herokuapp.com/api/v1/difficulties/50"
        }
        ```

## Series

### Table information

| Field     | Type    | Description                                   |
| --------- | ------- | --------------------------------------------- |
| id        | integer | Series identifier                             |
| city      | string  | Name of the city were the series belong       |
| latitude  | float   | Latitude geographic of the city               |
| longitude | float   | Longitude geographic of the city              |
| zoom      | integer | Zoom of the map (usually a parameter of maps) |

### Endpoints

#### `/series`

-   #### Methods

    `GET` <small>Endpoint for a list of the series registered in the database</small>

    `POST` <small>Endpoint to register a new series in the database</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        -   ##### `page = [numeric] | default = 1`
            <small>_Used to specify the page number you want to access._</small>
        -   ##### `limit = [numeric] | default = 25`
            <small>_Used to specify the maximum number of elements on a page of the answer._</small>
        -   ##### `fields = [alphanumeric] | default = id,city`
            <small>_Used to specify the fields to get from the list items, it will give one of them separated by a comma._</small>
        -   ##### `sort = [alphabetic] | default = id`
            <small>_Used to specify a field by which to sort items in the list._</small>
        -   ##### `order = [alphabetic] | default = asc`
            <small>_Used to specify a direction by which to sort items in the list._</small>
        -   ##### `filter = [alphanumeric] | default = null`
            <small>_Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`_</small>
-   #### Data Params
    -   ##### Required:
        `city` `latitude` `longitude` `zoom`
    -   ##### Optional:
        `...`
-   #### Headers

    -   ##### Required:

        -   `POST`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:
    -   ##### `201 Created (POST)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Series created successfully.",
            "data": {
                "id": 51,
                "city": "New York",
                "latitude": 13.21816,
                "longitude": -26.15646,
                "zoom": 15,
                "created_at": "2019-05-21 07:07:22",
                "updated_at": "2019-05-21 07:07:22"
            }
        }
        ```
    -   ##### `206 Partial Content (GET)`
        ```json
        {
            "success": true,
            "type": "collection",
            "message": "Series retrieved successfully.",
            "data": {
                "count": 25,
                "series": [
                    {
                        "series": {
                            "id": 1,
                            "city": "New Nellaside"
                        },
                        "links": {
                            "self": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/series/1"
                            }
                        }
                    },
                    {
                        "...": "..."
                    }
                ],
                "links": {
                    "prev": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/series?page=1"
                    },
                    "next": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/series?page=2"
                    },
                    "first": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/series?page=1"
                    },
                    "last": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/series?page=2"
                    }
                }
            }
        }
        ```
-   #### Error Response:

    -   ##### `400 Bad Request (POST)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "city": ["The city field is required."],
                "latitude": ["The latitude field is required."],
                "longitude": ["The longitude field is required."],
                "zoom": ["The zoom field is required."]
            }
        }
        ```
    -   ##### `401 Unauthorized (POST)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

#### `/series/:id`

-   #### Methods

    `GET` <small>Endpoint to get information about a specific series</small>

    `PUT` <small>Endpoint to update the information of a specific series</small>

    `DELETE` <small>Endpoint to remove a specific series</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `city` `latitude` `longitde` `zoom`
-   #### Headers

    -   ##### Required:

        -   `DELETE | PUT`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:

    -   ##### `200 OK (GET)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Series retrieved successfully.",
            "data": {
                "series": {
                    "id": 10,
                    "city": "North Pierreport",
                    "latitude": 27.520578,
                    "longitude": -83.844109,
                    "zoom": 30,
                    "created_at": "2019-05-05 09:09:37",
                    "updated_at": "2019-05-05 09:09:37",
                    "games": [
                        {
                            "game": {
                                "id": 14,
                                "player": "Prof. Gerald Ondricka PhD"
                            },
                            "links": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/games/14"
                            }
                        }
                    ],
                    "photos": [
                        {
                            "photo": {
                                "id": 10,
                                "description": "Voluptate eum velit rerum enim doloribus tenetur et. Dicta dolore sint nulla ex doloremque. Pariatur ut eligendi velit ratione vitae sapiente. Vel atque quod vitae placeat. Maxime voluptas est asperiores inventore molestiae."
                            },
                            "links": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/photos/10"
                            }
                        }
                    ],
                    "links": {
                        "self": {
                            "href": "https://geoquizz-api.herokuapp.com/api/v1/series/10"
                        }
                    }
                }
            }
        }
        ```
    -   ##### `200 OK (PUT)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Series updated successfully.",
            "data": {
                "id": 10,
                "city": "New Jersey",
                "latitude": "26.15612",
                "longitude": "86.1861",
                "zoom": "15",
                "created_at": "2019-05-05 09:09:37",
                "updated_at": "2019-05-21 07:12:07"
            }
        }
        ```
    -   ##### `204 No Content (DELETE)`

        ```json

        ```

-   #### Error Response:

    -   ##### `400 Bad Request (PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "city": ["The city field must have a value."],
                "latitude": ["The latitude must be a number."],
                "longitude": ["The longitude must be a number."],
                "zoom": ["The zoom must be a number."]
            }
        }
        ```

    -   ##### `401 Unauthorized (DELETE | PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

    -   ##### `404 Not Found (GET | PUT | DELETE)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 404,
            "message": "Information not found for: https://geoquizz-api.herokuapp.com/api/v1/series/50"
        }
        ```

## Photos

### Table information

| Field       | Type    | Description                                   |
| ----------- | ------- | --------------------------------------------- |
| id          | integer | Photo identifier                              |
| description | string  | Description of the image                      |
| latitude    | float   | Latitude geographic of the city               |
| longitude   | float   | Longitude geographic of the city              |
| url         | string  | Url of the image                              |
| idSeries    | integer | Zoom of the map (usually a parameter of maps) |

### Endpoints

#### `/photos`

-   #### Methods

    `GET` <small>Endpoint for a list of photos registered in the database</small>

    `POST` <small>Endpoint to register a new photo in the database</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        -   ##### `page = [numeric] | default = 1`
            <small>_Used to specify the page number you want to access._</small>
        -   ##### `limit = [numeric] | default = 25`
            <small>_Used to specify the maximum number of elements on a page of the answer._</small>
        -   ##### `fields = [alphanumeric] | default = id,description`
            <small>_Used to specify the fields to get from the list items, it will give one of them separated by a comma._</small>
        -   ##### `sort = [alphabetic] | default = id`
            <small>_Used to specify a field by which to sort items in the list._</small>
        -   ##### `order = [alphabetic] | default = asc`
            <small>_Used to specify a direction by which to sort items in the list._</small>
        -   ##### `filter = [alphanumeric] | default = null`
            <small>_Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`_</small>
-   #### Data Params
    -   ##### Required:
        `description` `latitude` `longitude` `zoom`
    -   ##### Optional:
        `idSeries`
-   #### Headers

    -   ##### Required:

        -   `POST`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:
    -   ##### `201 Created (POST)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Photo created successfully.",
            "data": {
                "id": 51,
                "description": "A good place",
                "latitude": 15.6156165,
                "longitude": 20.6548664,
                "url": "https://www.imagehost.com/ad654da56s4",
                "idSeries": 20,
                "created_at": "2019-05-21 07:25:13",
                "updated_at": "2019-05-21 07:25:13"
            }
        }
        ```
    -   ##### `206 Partial Content (GET)`
        ```json
        {
            "success": true,
            "type": "collection",
            "message": "Photos retrieved successfully.",
            "data": {
                "count": 25,
                "photos": [
                    {
                        "photo": {
                            "id": 1,
                            "description": "Incidunt optio assumenda aperiam. Id sit minus illum. Repellendus molestiae dicta dignissimos doloremque quibusdam eius fuga. Repudiandae laboriosam nihil est."
                        },
                        "links": {
                            "self": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/photos/1"
                            }
                        }
                    },
                    {
                        "...": "..."
                    }
                ],
                "links": {
                    "prev": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/photos?page=1"
                    },
                    "next": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/photos?page=2"
                    },
                    "first": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/photos?page=1"
                    },
                    "last": {
                        "href": "https://geoquizz-api.herokuapp.com/api/v1/photos?page=3"
                    }
                }
            }
        }
        ```
-   #### Error Response:

    -   ##### `400 Bad Request (POST)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "description": ["The description field is required."],
                "idSeries": [
                    "The id series must be a number.",
                    "The selected id series is invalid."
                ],
                "latitude": [
                    "The latitude field is required.",
                    "The latitude must be a number."
                ],
                "longitude": [
                    "The longitude field is required.",
                    "The longitude must be a number."
                ],
                "url": [
                    "The url field is required.",
                    "The url format is invalid."
                ]
            }
        }
        ```
    -   ##### `401 Unauthorized (POST)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

#### `/photos/:id`

-   #### Methods

    `GET` <small>Endpoint to get information about a specific photo</small>

    `PUT` <small>Endpoint to update the information of a specific photo</small>

    `DELETE` <small>Endpoint to remove a specific photo</small>

-   #### URL Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `...`
-   #### Data Params
    -   ##### Required:
        `...`
    -   ##### Optional:
        `description` `latitude` `longitde` `url` `idSeries`
-   #### Headers

    -   ##### Required:

        -   `DELETE | PUT`

            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (login's token)`

    -   ##### Optional:
        `...`

-   #### Success Response:

    -   ##### `200 OK (GET)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Photo retrieved successfully.",
            "data": {
                "photo": {
                    "id": 25,
                    "description": "Deserunt ullam ut quo consequatur. Voluptatem non qui voluptatem nihil eos pariatur adipisci. Voluptatum dolor excepturi dolor ut dolorum. Sint sit perferendis animi sint consequatur officia.",
                    "latitude": 55.871643,
                    "longitude": 169.674947,
                    "url": "https://nicolas.com/beatae-molestiae-at-necessitatibus-dicta-veritatis-reiciendis-quis-et.html",
                    "idSeries": 29,
                    "created_at": "2019-05-05 09:09:38",
                    "updated_at": "2019-05-05 09:09:38",
                    "series": [
                        {
                            "series": {
                                "id": 29,
                                "city": "Bethelberg"
                            },
                            "links": {
                                "href": "https://geoquizz-api.herokuapp.com/api/v1/series/29"
                            }
                        }
                    ],
                    "links": {
                        "self": {
                            "href": "https://geoquizz-api.herokuapp.com/api/v1/photos/25"
                        }
                    }
                }
            }
        }
        ```
    -   ##### `200 OK (PUT)`
        ```json
        {
            "success": true,
            "type": "resource",
            "message": "Photo updated successfully.",
            "data": {
                "id": 25,
                "description": "A good place",
                "latitude": "18.00001",
                "longitude": "19.00002",
                "url": "https://www.imageonline.net/image/5a65sd5",
                "idSeries": "50",
                "created_at": "2019-05-05 09:09:38",
                "updated_at": "2019-05-21 07:31:25"
            }
        }
        ```
    -   ##### `204 No Content (DELETE)`

        ```json

        ```

-   #### Error Response:

    -   ##### `400 Bad Request (PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 400,
            "message": "There was an error with the fields.",
            "errors": {
                "description": ["The description field must have a value."],
                "idSeries": [
                    "The id series must be a number.",
                    "The selected id series is invalid."
                ],
                "latitude": ["The latitude must be a number."],
                "longitude": ["The longitude must be a number."],
                "url": ["The url format is invalid."]
            }
        }
        ```

    -   ##### `401 Unauthorized (DELETE | PUT)`

        ```json
        {
            "success": false,
            "type": "error",
            "status": 401,
            "message": "Unauthenticated. You need to be logged to make this action"
        }
        ```

    -   ##### `404 Not Found (GET | PUT | DELETE)`
        ```json
        {
            "success": false,
            "type": "error",
            "status": 404,
            "message": "Information not found for: https://geoquizz-api.herokuapp.com/api/v1/photos/50"
        }
        ```

# Notes

All information shown in this documentation is fictitious and is used only as a demonstration of API results.

# License

[MIT license](https://opensource.org/licenses/MIT).
