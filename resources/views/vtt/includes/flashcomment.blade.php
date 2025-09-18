{{--Flash For Comment - Success Message--}}

@if (session()->has('comment-success'))
    <div class="col-md-12">
        <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div>
                {!! session()->get('comment-success') !!}
            </div>
        </div>
    </div>
@endif
