<div style="position:relative">
    <div class="input-group input-group-solid">
        <span class="input-group-text" id="search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"/>
                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"/>
            </svg>
        </span>
        {{--{{$models}}--}}
        {{--<span class="input-group-text" id="search">--}}
            {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
                {{--<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>--}}
                {{--<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>--}}
            {{--</svg>--}}
        {{--</span>--}}

        <input wire:model.debounce.500ms="search" id="{{ $seId }}" class="form-control" type="text"  placeholder="{{$placeholder ?? 'Search employee'}}" aria-label="search" aria-describedby="search"  @if($show) disabled @endif />
        @if(!empty($search))
            <button wire:click="$set('search', '')" class="input-group-text btn btn-light" type="button" id="button-addon2"><i class="las la-times"></i></button>
        @endif
    </div>
    <div style="position:absolute; z-index:100; left: 0; right: 0; ">
        @if(strlen($search)>2)
            @if(count($searchResultItems)>0)
                <ul class="list-group rounded-0">
                    @foreach($searchResultItems as $sri)
                        <li class="list-group-item list-group-item-action">
                            <a href="#" class="d-block pe-auto" style="margin: 0 !important;" wire:click="searchSelectItem({{$sri->id}})">
                            {{--<a href="#" class="d-block pe-auto" style="margin: 0 !important;">--}}
                                {{--<img class="float-start" src="{{ asset('storage/avatar.jpg') }}" style="object-fit: contain; border-radius: 4px; width: 60px; height: 40px; margin-right: 10px;" />--}}
                                <strong>{!! $sri->first_name ?? '' !!} {!! $sri->middle_name ?? '' !!} {!! $sri->last_name ?? '' !!}</strong><br/>
                                <span>{{ $sri->position ?? "None" }} </span>&nbsp;&nbsp;<br/>
                                <span class="text-muted">{{$sri->department ?? 'None'}} </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <ul class="list-group rounded-0">
                    <li class="list-group-item">Found nothing...</li>
                </ul>
            @endif
        @endif
    </div>
</div>
