<?php

namespace OCA\Marble\Controller;

use \OCA\AppFramework\Controller\Controller;
use \OCA\AppFramework\Http\JSONResponse;
use \OCA\AppFramework\Http\Http;

use \OCA\Marble\Db\RouteMapper;
use \OCA\Marble\Db\Route;
use \OCA\Marble\BusinessLayer\RouteBusinessLayer;


class APIController extends Controller {

    public function __construct($api, $request) {
        parent::__construct($api, $request);
    }

    /**
     * @IsAdminExemption
     * @IsSubAdminExemption
     * @Ajax
     * @CSRFExemption
     * @API
     */
    public function routesGetAll() {
        $layer = new RouteBusinessLayer($this->api);
        $userId = $this->api->getUserId();

        $routes = $layer->findAll($userId);

        return new JSONResponse($routes);
    }

    /**
     * @IsAdminExemption
     * @IsSubAdminExemption
     * @Ajax
     * @CSRFExemption
     * @API
     */
    public function routesCreate() {
        $mapper = new RouteMapper($this->api);

        $params = $this->getParams();
        $params['userId'] = $this->api->getUserId();

        $route = Route::fromParams($params);
        $route = $mapper->insert($route);
        return new JSONResponse(array(), Http::STATUS_CREATED);
    }

}