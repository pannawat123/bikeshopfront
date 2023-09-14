@extends("layouts.master")
@section('title') BikeShop | ประเภทสินค้า @stop
@section('content')
<h1>ประเภทสินค้า</h1>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <strong>รายการประเภท</strong>
            </div>
        </div>
    <div class="panel-body">
        <a href="{{ URL::to('category/edit') }}" class="btn btn-success pull-right">เพิ่มสินค้า</a>
        <form action="{{URL::to('category/search') }}" method="post" class="form-inline">
        {{ csrf_field() }}
            <input type="text" name="q" class="form-control" placeholder="พิมพ์รหัสหรือชื่อเพื่อค้นหา">
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
    <br>
        <table class="table table-bordered bs_table">
            <thead>
                <tr>
                    <th>รหัสประเภท</th>
                    <th>ชื่อประเภท</th>
                    <th>การทำงาน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                <tr>
                    <td> {{$c->id }} </td>
                    <td> {{$c->name }} </td>
                    <td class="bs-center">
                        <a href="{{URL::to('category/edit/'.$c->id)}}" class="btn btn-info"> <i class="fa fa-edit"></i> แก้ไข</a>
                        <a href="#" class="btn btn-danger btn-delete" id-delete="{{$c->id}}">
                            <i class="fa fa-trash"></i> ลบ</a>
                    </td>
                
                </tr> @endforeach
            </tbody>
           

        </table>
        <tfoot>
            <th class="bs-categoryall"> <h4> ยอดรวมทั้งหมด {{ number_format($categories->count() , 0) }} รายการ  </h4> </th>
        </tfoot>

        <div class="bs-next">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.btn-delete').click(function () {
            var id = $(this).attr('id-delete');
            if (confirm('คุณต้องการลบข้อมูลใช่หรือไม่')) {
                window.location.href = '/category/remove/' + id;
            }
        });
    });

</script>
@endsection