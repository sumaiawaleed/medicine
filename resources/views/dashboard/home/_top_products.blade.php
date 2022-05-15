<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recently Added Products</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($data['top_products'] as $p)
                    @if($p->product)
                        <li class="item">
                            <div class="product-img">
                                <img src="{{ $p->product->image_path }}"
                                     alt="{{ $p->product->getTranslateName(app()->getLocale()) }}" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)"
                                   class="product-title">{{ $p->product->getTranslateName(app()->getLocale()) }}
                                    <span class="badge badge-warning float-right">{{ $p->total_orders }}</span></a>
                                <span class="product-description">
                        {{ $p->product->notes }}
                      </span>
                            </div>
                        </li>
                @endif
            @endforeach
            </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <a href="{{ route(env('DASH_URL').'.products.index') }}" class="uppercase">@lang('site.v_products')</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
