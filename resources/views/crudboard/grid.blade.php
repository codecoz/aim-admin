<div class="content">
    @if($grid->getFilter()->getFields()->count() > 0)
        <x-aim-admin::grid-filter/>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                @if($grid->getTitle())
                    {!! $grid->getTitle() !!}
                @else
                    {!! $attributes['title'] !!}
                @endif
            </h3>
            <div class="card-tools">
                <div class="input-group mr-2">
                    @foreach ($grid->getActions() as $crudAction)
                        @php
                            $htmlAttributes = $crudAction->getAttributesAsHtml();
                        @endphp
                        <x-dynamic-component :component="$crudAction->getComponent()" :$crudAction :$htmlAttributes/>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(config('aim-admin.show_inline_alert_box', true))
                <x-aim-admin::utils.error :messages="$errors->all()" class="mt-2"/>
            @endif
            <div class="table-responsive">
                <table class="table {{ $grid->getTableCssClass() }}">
                    <thead class="{{ $grid->getHeaderRowCssClass() }}">
                    <tr>
                        @if(!$grid->isDisableSerialColumn())
                            <th class="text-center" style="width: 5%">#</th>
                        @endif
                        @foreach ($grid->getColumns() as $column)
                            <th
                                class="{{ $column->getCssClass() }}" {!! $column->getAttributesAsHtml() !!} >{!! $column->getLabel() !!}</th>
                        @endforeach
                        @if ($grid->getRowActions()->count())
                            <th>{{$grid->getActionLevel() }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $gridData = $grid->getGridData();
                        $perPage = $gridData->perPage()??10;
                        $currentPage = $gridData->currentPage();
                        $indexCount = $perPage*($currentPage-1);
                    @endphp
                    @forelse($gridData as $k=>$row)
                        @php
                            $rowCssClass = $grid->getRowCssClass($row);
                            $rowCss = $grid->getRowCss($row);
                        @endphp
                        <tr @if($rowCssClass) class="{{ $rowCssClass }}" @endif>
                            @if(!$grid->isDisableSerialColumn())
                                <th class="text-center">{{ $indexCount + $k + 1 }}</th>
                            @endif
                            @foreach ($grid->getColumns() as $column)
                                <td class="{{ $column->getCssClass() }}">
                                    @php
                                        $value = $row[$column->getName()] ;
                                        if($formaterFunc = $column->getFormatValueCallable()){
                                        $value = $formaterFunc($value,$row);
                                        }
                                    @endphp
                                    <x-dynamic-component :component="$column->getComponent()" :$value :$row/>
                                </td>
                            @endforeach
                            @if($grid->getRowActions()->count())
                                <td class="text-center">
                                    @foreach ($grid->getRowActions() as $rowAction)
                                        @php
                                            $routeParams = $rowAction->getRouteParameters();
                                            if ($routeParams instanceof \Closure) {
                                            $routeParams = $routeParams($row);
                                            } else {
                                            foreach ($routeParams as $key => $val) {
                                            $routeParams[$key] = $row[$val];
                                            }
                                            empty($routeParams) && ($routeParams['id'] = $row['id']);
                                            }
                                            $htmlAttributes = $rowAction->getAttributesAsHtml();
                                        @endphp
                                        @if($rowAction->shouldBeDisplayedFor($row))
                                            <x-dynamic-component :component="$rowAction->getComponent()" :$rowAction
                                                                 :$routeParams :$htmlAttributes/>
                                        @endif
                                    @endforeach
                                </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td @if ($grid->getRowActions()->count())
                                    colspan="{{ $grid->getColumns()->count() + 2 }}"
                                @else
                                    colspan="{{ $grid->getColumns()->count() + 1 }}"
                                @endif
                                class="text-center">No record is
                                found
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
                <x-aim-admin::crudboard.pagination :data="$gridData"/>
            </div>
        </div>
    </div>
</div>
