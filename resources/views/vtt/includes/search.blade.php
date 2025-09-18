{!! Form::open(['method'=>'GET','url'=>$url,'class'=>'navbar-form navbar-left','role'=>'search'])  !!}
<a href="{{ url($link.'/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add</a>
<div class="input-group custom-search-form">
    <input type="text" class="form-control" name="search" placeholder="Search...">
    <span class="input-group-btn">
        <button class="btn btn-default-sm" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </span>
</div>
<a href="/{{$link}}" class="btn btn-success">Main list</a> 
{!! Form::close() !!}