<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\PhotoResource;
use App\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PhotoController extends BaseController
{
    /**
     * @return Response
     */
    public function index()
    {
        $photos = []; //The final photos array
        $page = Input::get('page', 1); //Page parameter in GET, default = 1
        $limit = Input::get('limit', 25); //Limit parameter in GET, default = 25
        $inputFields = Input::get('fields', 'id,description'); //String result from fields parameter in GET
        $fields = explode(',', $inputFields); //Array of fields parameter in GET separated
        $sort = Input::get('sort', 'id'); //Sort parameter in GET, default = id
        $order = Input::get('order', 'asc'); //Order parameter in GET, default = asc
        $filter = Input::get('filter'); //String result from filter parameter in GET, default = null
        $filterFields = explode(',', $filter); //Array for each filter field in filter parameter in GET
        $filterData = []; // Final array of filter data
        foreach ($filterFields as $filterField) {
            //Separation of fields in the filters to an array
            array_push($filterData, explode(':', $filterField));
        }
        $count = Photo::all()->count(); //Count of all the photos
        $offset = (--$page) * $limit; // Number of elements that will going to be ignored
        $lastPage = ceil($count / $limit); //Value of last page in the pagination
        $dbPhotosQ = Photo::query(); //Creation of a query for photos

        //Get all the photos with the selected columns, the number of hidden elements and how many there is
        //going to appear and the order parameters for the result
        $dbPhotosQ->select($fields)->skip($offset)->take($limit)->orderBy($sort, $order);

        if ($filter !== null) { //If there is a change in the filter parameters
            foreach ($filterData as $filterDatum) {
                //For each filter, the second parameter is going to be evaluated (operator)
                switch ($filterDatum[1]) {
                    case 'like':
                        $dbPhotosQ->where($filterDatum[0], 'LIKE', '%' . $filterDatum[2] . '%');
                        break;
                    case '=':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '!=':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '<=':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    case '>=':
                        $dbPhotosQ->where($filterDatum[0], $filterDatum[1], $filterDatum[2]);
                        break;
                    default:
                        //If it's different an error is sent
                        return $this->sendError('You have a syntax error in the filter. Filter only accepts: like, =, >, >=, <, <=, !=', [], 400);
                }
            }
        }

        //Execution of the entire request
        $dbPhotos = PhotoResource::collection($dbPhotosQ->get());

        foreach ($dbPhotos as $photo) {
            //Each element in the database response is added to the $photos array
            array_push($photos, ['photo' => $photo,
                'links' => ['self' => ['href' => route('photo', ['photos' => $photo])]]]);
        }

        //Links for pagination created
        $prev = ['href' => route('photos') . '?page=' . ($page)];
        $next = ['href' => route('photos') . '?page=' . ($page + 2)];
        $first = ['href' => route('photos') . '?page=1'];
        $last = ['href' => route('photos') . '?page=' . $lastPage];

        //If the route is for the first page the link for the previous pager will be the same than the first page
        if ($page == 0) {
            $prev = $first;
        }

        //If the route is for the last page the link for the next pager will be the same than the last page
        if ($page + 1 == $lastPage) {
            $next = $last;
        }

        //If $limit is different than default, GET parameter is added in the pagination links
        if ($limit !== 25) {
            $prev['href'] .= '&limit=' . $limit;
            $next['href'] .= '&limit=' . $limit;
            $first['href'] .= '&limit=' . $limit;
            $last['href'] .= '&limit=' . $limit;
        }

        //If $sort is different than default, GET parameter is added in pagination links
        if ($sort !== 'id') {
            $prev['href'] .= '&sort=' . $sort;
            $next['href'] .= '&sort=' . $sort;
            $first['href'] .= '&sort=' . $sort;
            $last['href'] .= '&sort=' . $sort;
        }

        //If $order is different than default, GET parameter is added in pagination links
        if ($order !== 'asc') {
            $prev['href'] .= '&order=' . $order;
            $next['href'] .= '&order=' . $order;
            $first['href'] .= '&order=' . $order;
            $last['href'] .= '&order=' . $order;
        }

        //If $fields is different than default, GET parameter is added in pagination links
        if ($fields !== ['id', 'description']) {
            $prev['href'] .= '&fields=' . implode(',', $fields);
            $next['href'] .= '&fields=' . implode(',', $fields);
            $first['href'] .= '&fields=' . implode(',', $fields);
            $last['href'] .= '&fields=' . implode(',', $fields);
        }

        //If $filter is different than default, GET parameter is added in pagination links
        if ($filter !== null) {
            $prev['href'] .= '&filter=' . $filter;
            $next['href'] .= '&filter=' . $filter;
            $first['href'] .= '&filter=' . $filter;
            $last['href'] .= '&filter=' . $filter;
        }

        //Construction of the response
        $data = [
            'count' => count($photos),
            'photos' => $photos,
            'links' => [
                'prev' => $prev,
                'next' => $next,
                'first' => $first,
                'last' => $last
            ]
        ];

        //Return of a successful response
        return $this->sendResponse($data, 'Photos retrieved successfully.', 206, 'collection');
    }

    /**
     * @param Photo $photo
     * @return Response
     */
    public function show(Photo $photo)
    {
        //Photo obtained from database
        $dbPhoto = new PhotoResource($photo);
        $seriesPhotos = $dbPhoto->series()->get(['id', 'city']);
        $series = [];
        foreach ($seriesPhotos as $seriesPhoto) {
            array_push($series, [
                'series' => $seriesPhoto,
                'links' => ['href' => route('aSeries', ['series' => $seriesPhoto->id])]//route() is to get te URI of and specific route
            ]);
        }


        //Construction of data
        $dbPhoto['series'] = $series;
        $dbPhoto['links'] = ['self' => ['href' => route('photo', ['photo' => $photo])]];

        $data = ['photo' => $dbPhoto,];

        //Return of a successful response
        return $this->sendResponse($data, 'Photo retrieved successfully.');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //POST parameters are obtained from the request
        $params = $request->all();

        //Validation for the parameters
        $validator = Validator::make($params, [
            'description' => 'required',
            'idSeries' => 'numeric|exists:series,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'url' => 'required|url',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error with the fields.', $errors, 400);
        }

        //If all the validations are right the new photo is created
        $photo = Photo::create($params);
        //The new photo is searched in the database
        $photoAfterCreate = Photo::find($photo->id);

        //Response of a successful result
        return $this->sendResponse(new PhotoResource($photoAfterCreate), 'Photo created successfully.', 201);
    }

    /**
     * @param Request $request
     * @param Photo $photo
     * @return Response
     */
    public function update(Request $request, Photo $photo)
    {
        //PUT parameters are obtained from the request
        $params = $request->all();

        //Validation for the parameters
        $validator = Validator::make($params, [
            'description' => 'filled',
            'idSeries' => 'numeric|exists:series,id',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'url' => 'url',
        ]);
        if ($validator->fails()) {
            //If the parameters doesnt make the validation, errors are obtained from $validator
            $errors = $validator->errors();
            //An error is sent
            return $this->sendError('There was an error with the fields.', $errors, 400);
        }

        //If all the validations are right the photo is updated
        $photo->update($params);

        //Response of a successful result
        return $this->sendResponse(new PhotoResource($photo), 'Photo updated successfully.', 200);
    }

    /**
     * @param Photo $photo
     * @return Response
     * @throws Exception
     */
    public function destroy(Photo $photo)
    {
        //Deletion of the sent photo
        $photo->delete();

        //Response with status 204 (No Content)
        return $this->sendResponse("", [], 204);
    }

}