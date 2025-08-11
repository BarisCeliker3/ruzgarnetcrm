<div class="mt-2 card border-2 border-double border-teal-400 rounded-lg shadow-lg p-6 mb-6 bg-white">
  <div class="card-content">
    <div class="card-body">
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($totals as $item)
        @if ($item->type != 0)
          <div class="col-12 md:col-6 lg:col-4 xl:col-3 mb-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-[#5dcffd]">
              <div class="p-6 flex items-center justify-between">
                <div class="flex flex-col space-y-2">
                  <h4 class="text-lg font-semibold text-gray-600">
                    {{ $typeLabels[$item->type] ?? 'Bilinmeyen Tür' }}
                  </h4>
                </div>
                <div class="text-4xl text-[#5dcffd]">
                  <i class="icon-graph"></i>
                </div>
              </div>
              <div class="p-4 bg-[#f4f9fd] rounded-b-lg">
                <h1 class="text-2xl font-bold text-gray-800">
                  {!! number_format($item->total_price, 2, ',', '.') !!} ₺
                </h1>
              </div>
            </div>
          </div>
        @endif
      @endforeach
      </div>
    </div>
  </div>
</div>
