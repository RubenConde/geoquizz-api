<p  align="center"><img  src="https://geoquizz.rubencondemag.info/img/world.28acccfd.png" width="200"></p>

<p  align="center"><a  href="https://geoquizz-api.herokuapp.com/"><img  src="https://heroku-badge.herokuapp.com/?app=geoquizz-api"  alt="Build Status"></a></p>

- [About GéoQuizz API](#about-g-oquizz-api)
  * [Structure](#structure)
    + [Authentication](#authentication)
      - [Endpoints](#endpoints)
        - [`/register`](#register)
        - [`/login`](#login)
        - [`/logout`](#logout)
    + [Games](#games)
      - [Table information](#table-information)
      - [Endpoints](#endpoints-1)
        - [`/games`](#games-1)
        - [`/games/{id}`](#gamesid)
- [License](#license)

# About GéoQuizz API

GéoQuizz API is a RESTful API for the consumption of the game of the same name, made mainly in PHP using the Laravel framework in its version 5.8 and deployed in a heroku server for its use.

## Structure

### Authentication

#### Endpoints

-   #### `/register`
    -   ##### Methods
        `POST`
    -   ##### Data Params
        -   ##### Required:
            `name` `email` `password` `password_confirmation`
        -   ##### Optional:
            `...`
    -   ##### Success Response:
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
    -   ##### Error Response:
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
-   #### `/login`
    -   ##### Methods
        `POST`
    -   ##### Data Params
        -   ##### Required:
            `email` `password`
        -   ##### Optional:
            `...`
    -   ##### Success Response:
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
    -   ##### Error Response:
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
-   #### `/logout`
    -   ##### Methods
        `GET`
    -   ##### URL Params
        -   ##### Required:
            `...`
        -   ##### Optional:
            `...`
    -   ##### Header Params
        -   ##### Required:
            `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (token from login)`
        -   ##### Optional:
            `...`
    -   ##### Success Response:
        -   ##### `200 OK`
            ```json
            {
                "success": true,
                "type": "resource",
                "message": "You have been successfully logged out!",
                "data": ""
            }
            ```
    -   ##### Error Response:
        -   ##### `401 Unauthorized`
            ```json
            {
                "success": false,
                "type": "error",
                "status": 401,
                "message": "Unauthenticated. You need to be logged to make this action"
            }
            ```

### Games

#### Table information

| Field        | Type    | Description                                                                               |
| ------------ | ------- | ----------------------------------------------------------------------------------------- |
| id           | integer | Game identifier                                                                           |
| player       | string  | Name of the player                                                                        |
| status       | integer | Game status *`0 = completed` `1 = started` `2 = completed but not visible in scoreboard`* |
| score        | integer | Game score                                                                                |
| idSeries     | integer | Identifier of the series to which it belongs                                              |
| idDifficulty | integer | Identifier of the difficulty to which it belongs                                          |

#### Endpoints

-   #### `/games`
    -   ##### Methods
        `GET` `POST`
    -   ##### URL Params
        -   ##### Required:
            `...`
        -   ##### Optional:
            -   ##### `page = [numeric] | default = 1`
                ###### <small>_Used to specify the page number you want to access._</small>
            -   ##### `limit = [numeric] | default = 25`
                ###### <small>_Used to specify the maximum number of elements on a page of the answer._</small>
            -   ##### `fields = [alphanumeric] | default = id,player`
                ###### <small>_Used to specify the fields to get from the list items, it will give one of them separated by a comma._</small>
            -   ##### `sort = [alphabetic] | default = id`
                ###### <small>_Used to specify a field by which to sort items in the list._</small>
            -   ##### `order = [alphabetic] | default = asc`
                ###### <small>_Used to specify a direction by which to sort items in the list._</small>
            -   ##### `filter = [alphanumeric] | default = null`
                ###### <small>_Used to get a list filtered by a field giving a specific value. These are separated by a colon. e.g. = `field:operator:value`. Available operators: `=, !=, <, <=, >, >=`_</small>
    -   ##### Data Params
        -   ##### Required:
            `player` `idSeries` `idDifficulty`
        -   ##### Optional:
            `status` `score`
    -   ##### Success Response:
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
                                    "href": "http://127.0.0.1:8000/api/v1/games/1"
                                }
                            }
                        },
                        {
                            "...": "..."
                        }
                    ],
                    "links": {
                        "prev": {
                            "href": "http://127.0.0.1:8000/api/v1/games?page=1"
                        },
                        "next": {
                            "href": "http://127.0.0.1:8000/api/v1/games?page=2"
                        },
                        "first": {
                            "href": "http://127.0.0.1:8000/api/v1/games?page=1"
                        },
                        "last": {
                            "href": "http://127.0.0.1:8000/api/v1/games?page=3"
                        }
                    }
                }
            }
            ```
    -   ##### Error Response:
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
-   #### `/games/{id}`
    -   ##### Methods
        `GET` `PUT` `DELETE`
    -   ##### URL Params
        -   ##### Required:
            `...`
        -   ##### Optional:
            `...`
    -   ##### Data Params
        -   ##### Required:
            `...`
        -   ##### Optional:
            `status` `score` `player` `idSeries` `idDifficulty`
    -   ##### Header Params
        -   ##### Required:
            -   `@DELETE`
                
                `Authorization` : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJS... (token from login)`
        -   ##### Optional:
            `...`

    -   ##### Success Response:
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
                                    "href": "http://127.0.0.1:8000/api/v1/series/38"
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
                                    "href": "http://127.0.0.1:8000/api/v1/series/17"
                                }
                            }
                        ],
                        "links": {
                            "self": {
                                "href": "http://127.0.0.1:8000/api/v1/games/25"
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
                    "id": 49,
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
        -   ##### `204 No Content (GET)`
            ```json
            ```
    -   ##### Error Response:
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
        -   ##### `404 Not Found (GET | PUT | DELETE)`
            ```json
            {
                "success": false,
                "type": "error",
                "status": 404,
                "message": "Information not found for: http://127.0.0.1:8000/api/v1/games/50"
            }
            ```
# License

[MIT license](https://opensource.org/licenses/MIT).
