<div>
    @if(tenant())
        @if (tenant()->photo_path)
            <img src="{{ url("storage/".tenant()->photo_path) }}"
                alt="{{ tenant()->name }}" class="">
        @else
            <img src="{{ url('img/tenants/noimage.png') }}" alt="{{ tenant()->name }}"
                class="">
        @endif
    @endif
</div>