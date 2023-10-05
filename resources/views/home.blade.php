@extends('layouts.master')
@section('title')
    BikeShop | อุปกรณ์จักรยาน, อะไหล่, ชุดแข่ง และอุปกรณ์ตกแต่ง
@endsection

@section('content')
    <div class="container" ng-app="app" ng-controller="ctrl">
        <div class="row">
            <div class="col-md-3">
                <h1 style="margin: 0 0 30px 0">สินค้าในร้าน</h1>
                <div class="list-group">
                    <a href="#" class="list-group-item" ng-class="{'active': category == null}"
                        ng-click="getProductList(null)">ทั้งหมด</a>
                    <a href="#" class="list-group-item" ng-repeat="c in categories" ng-click="getProductList(c)"
                        ng-class="{'active': category.id == c.id}">@{c.name}</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="pull-right" style="margin-top:10px">
                    <input type="text" class="form-control" ng-model="query" ng-keyup="searchProduct($event)"
                        style="width:190px" placeholder="พิมพ์ชื่อสินค้าเพื่อค้นหา"><br>
                    {{-- กรณีไม่พบข้อมูลสินค้า ให้แสดง คำว่า ไม่พบข้อมูลสินค้า --}}
                </div>
            </div>


            <div class="col-md-3" ng-repeat="p in products|filter:query">
                <div class="panel panel-default bs-product-card">
                    <!-- product card -->
                    <div class="panel-body">
                        <img src="@{p.image_url}" class="img-responsive">

                        <h4><a href="#">@{p.name}</a></h4>
                        <div class="form-group">
                            <div>คงเหลือ: @{p.stock_qty} </div>
                            <div>ราคา <strong>@{p.price | number:0}</strong> บาท</div>
                        </div>
                        <p>
                            <a href="#" class="btn btn-success btn-block"> @guest 
                                <i class="fa fa-shopping-cart"></i> หยิบใส่ตะกร้า</a> @else
                                <a href="#" class="btn btn-success btn-block" ng-click="addToCart(p)">
                                    <i class="fa fa-shopping-cart"></i> หยิบใส่ตะกร้า</a> @endguest
                                     
                        </p>
                    </div>
                    <!-- end product card -->

                </div>

            </div>
            <center>
                <h3 ng-if="!products.length">ไม่พบข้อมูลสินค้า </h3>
            </center>
        </div>

    </div>




    <script type="text/javascript">
        var app = angular.module('app', []).config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('@{').endSymbol('}');
        });

        app.service('productService', function($http) {
            this.getProductList = function(category_id) {
                if (category_id) {
                    return $http.get('/api/product/' + category_id);
                }
                return $http.get('/api/product');
            };

            this.getCateList = function() {
                return $http.get('/api/category')
            };

            this.searchProduct = function(query) {
                return $http.get({
                    url: '/api/product/search',
                    method: 'post',
                    data: {
                        'query': query
                    },
                });
            }
        });




        app.controller('ctrl', function($scope, productService) {
            $scope.category = {};
            $scope.products = [];
            $scope.getProductList = function(category) {
                $scope.category = category;
                category_id = category != null ? category.id : '';
                productService.getProductList(category_id).then(function(res) {
                    if (!res.data.ok) return;
                    $scope.products = res.data.products;
                });
            };
            $scope.getProductList(null);

            $scope.categories = [];
            $scope.getCateList = function() {
                productService.getCateList().then(function(res) {
                    if (!res.data.ok) return;
                    $scope.categories = res.data.categories;
                });
            };
            $scope.getCateList();

            $scope.searchProduct = function(e) {
                productService.searchProduct($scope.query).then(function(res) {
                    if (!res.data.ok) return;
                    $scope.products = res.data.products;


                });
            };

            $scope.addToCart = function(p) {   
                window.location.href = '/cart/add/' + p.id;
            };
        });





        // app.controller('ctrl', function($scope) {

        //     $scope.helloMessage = 'สวัสดี AngularJS';

        //     $scope.products = [{
        //             'code': 'P001',
        //             'name': 'ชุดแข่งสีดา Size L',
        //             'price': 1500.00,
        //             'qty': 5
        //         },
        //         {
        //             'code': 'P002',
        //             'name': 'หมวกันน็อกรุ่น SM-220',
        //             'price': 1400.00,
        //             'qty': 0
        //         },
        //         {
        //             'code': 'P003',
        //             'name': 'มิเตอร์วัดความเร็ว',
        //             'price': 1450.00,
        //             'qty': 2
        //         },
        //     ];
        // });
    </script>
@endsection
