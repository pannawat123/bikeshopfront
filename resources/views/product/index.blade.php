@extends('layouts.master') {{-- การสืบทอดโฟลเดอร์ --}}
@section('title') BikeShop | รายการสินค้า @stop {{-- หัวข้อ title html --}}
@section('content')
    <div class="container">
        <h1>รายการสินค้า</h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title"><strong>รายการ</strong></div>
            </div>
            <div class="panel-body">
                <a href="{{ URL::to('product/edit') }}" class="btn btn-success pull-right">เพิ่มสินค้า</a>
                <form action="{{ URL::to('product/search') }}" method="post" class="form-inline">
                    {{ csrf_field() }}
                    <input type="text" name="q" class="form-control" placeholder="พิมพ์รหัสหรือชื่อเพื่อค้นหา">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </form>
                
                <br>
                <table class="table table-bordered bs-table">
                    <thead>
                        <tr>
                            <th>รูปสินค้า </th>
                            <th>รหัส</th>
                            <th>ชื่อสินค้า </th>
                            <th>ประเภท</th>
                            <th>คงเหลือ</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>การทํางาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            {{-- ตัวแปร products ที่ถูกส่งมาจาก Controller --}}
                            <td><img src="{{ asset ($p->image_url) }}" width="50px"></td> 
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name }}</td>
                            <td class="bs-price">{{ number_format($p->stock_qty, 0) }}</td>
                            <td class="bs-price">{{ number_format($p->price, 2) }}</td>
                            <td class="bs-center">
                                <a href="{{ URL::to('product/edit/' . $p->id) }}" class="btn btn-info"><i
                                        class="fa fa-edit"></i> แก้ไข</a>
                                <a href="#" class="btn btn-danger btn-delete" id-delete="{{$p->id}}">
                                    <i class="fa fa-trash"></i> ลบ</a>
                            </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">รวม</th>
                            <th class="bs-price">{{ number_format($products->sum('stock_qty'), 0) }}</th>
                            <th class="bs-price">{{ number_format($products->sum('price'), 2) }}</th>
                        </tr>
                    </tfoot>

                </table>

                
                
                <div class="panel-footer ">
                    <span>แสดงข้อมูลจํานวน {{ count($products) }} รายการ</span>
                </div>
            </div>
            <div class="panel-one">
                {{ $products->links() }}
            </div>
            <br>
        </div>

        <script>
            $(document).ready(function () {
                $('.btn-delete').click(function () {
                    var id = $(this).attr('id-delete');
                    if (confirm('คุณต้องการลบข้อมูลใช่หรือไม่')) {
                        window.location.href = '/product/remove/' + id;
                    }
                });
            });

        </script>
    @endsection {{-- ปิด title html --}}