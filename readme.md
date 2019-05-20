<p  align="center"><img  src="https://geoquizz.rubencondemag.info/img/world.28acccfd.png" width=200></p>

<p  align="center"><a  href="https://geoquizz-api.herokuapp.com/"><img  src="https://heroku-badge.herokuapp.com/?app=geoquizz-api"  alt="Build Status"></a></p>

- [About GéoQuizz API](#about-g%C3%A9oquizz-api)
  - [Structure](#structure)
    - [Games](#games)
      - [Table information](#table-information)
      - [Endpoints](#endpoints)
- [License](#license)

# About GéoQuizz API

GéoQuizz API is a RESTful API for the consumption of the game of the same name, made mainly in PHP using the Laravel framework in its version 5.8 and deployed in a heroku server for its use.

## Structure

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
        -   `...`
    -   ##### Data Params
        -   ##### Required:
            `...`
        -   ##### Optional:
            `status` `score` `player` `idSeries` `idDifficulty`
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
