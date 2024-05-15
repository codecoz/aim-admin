 <div class="content">
     <x-aim-admin::grid-filter />
     <div class="card">
         <div class="card-header">
             <h3 class="card-title">
                @if($grid->getTitle())
                {{ $grid->getTitle() }}
                @else
                {{ $attributes['title'] }}
                @endif
            </h3>
             <div class="card-tools">
                 <div class="input-group mr-2" >
                 @foreach ($grid->getActions() as $crudAction)
             @php
             $htmlAttributes = $crudAction->getAttributesAsHtml();
             @endphp
             <x-dynamic-component :component="$crudAction->getComponent()" :$crudAction :$htmlAttributes />
             @endforeach
                 </div>
             </div>
         </div>
         <div class="card-body table-responsive p-0">
                 <table class="table {{ $grid->getTableCssClass() }}">
                     <thead class="{{ $grid->getHeaderRowCssClass() }}">
                         <tr>
                             <th scope="col">#</th>
                             @foreach ($grid->getColumns() as $column)
                             <th scope="col" class="{{ $column->getCssClass() }}" {{ $column->getAttributesAsHtml() }} >{{ $column->getLabel() }}</th>
                             @endforeach
                             @if ($grid->getRowActions()->count())
                             <th scope="col" style="width: 15%">{{$grid->getActionLevel() }}</th>
                             @endif
                         </tr>
                     </thead>
                     <tbody>
                         @forelse($grid->getGridData() as $k=>$row)
                         @php
                         $rowCssClass = $grid->getRowCssClass($row);
                         $rowCss = $grid->getRowCss($row);
                         @endphp
                         <tr @if($rowCssClass) class="{{ $rowCssClass }}" @endif>
                             <th scope="row">{{ $k + 1 }}</th>
                             @foreach ($grid->getColumns() as $column)
                             <td class="{{ $column->getCssClass() }}">
                                 @php
                                 $value = $row[$column->getName()] ;
                                 if($formaterFunc = $column->getFormatValueCallable()){
                                 $value = $formaterFunc($value,$row);
                                 }
                                 @endphp
                                 <x-dynamic-component :component="$column->getComponent()" :$value :$row />
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
                                 <x-dynamic-component :component="$rowAction->getComponent()" :$rowAction :$routeParams :$htmlAttributes />
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
                 <x-aim-admin::crudboard.pagination :data="$grid->getGridData()" />
             </div>
     </div>
 </div>
