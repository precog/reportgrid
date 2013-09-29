define([
      "order!jquery"
    , "order!ui/jquery.ui.sortable"
    , "order!jlib/slickgrid/jquery.event.drag-2.0.min"
    , "order!jlib/slickgrid/slick.core"
    , "order!jlib/slickgrid/slick.grid"
//    , "order!jlib/slickgrid/slick.groupitemmetadataprovider"
    , "order!jlib/slickgrid/slick.dataview"
    , "order!jlib/slickgrid/slick.pager"
    , "order!jlib/slickgrid/slick.columnpicker"
],

function() {
    var elPanel = $('<div class="ui-widget"><div class="pg-table" style="height:100%;width:100%"></div></div>'),
        elOutput = elPanel.find('.pg-table'),
        dataView = new Slick.Data.DataView(),
        grid,
        gridOptions = {
              enableCellNavigation: false
            , enableColumnReorder: true
            , autoHeight : false
            , forceFitColumns: true
            , multiColumnSort: true
        },
        wrapper;

    grid = new Slick.Grid(elOutput, dataView, [], gridOptions);

    dataView.setPagingOptions({
        pageSize: 20
    });
    dataView.onRowCountChanged.subscribe(function (e, args) {
        if(!grid) return;
        try {
            grid.updateRowCount();
        } catch(_) {}
        grid.render();
    });
    dataView.onRowsChanged.subscribe(function (e, args) {
        if(!grid) return;
        grid.invalidateRows(args.rows);
        grid.render();
    });

    function formatValue(row, cell, value, columnDef, dataContext, subordinate) {
        if("undefined" === typeof value) {
            return "[undefined]";
        } else if(value === null) {
            return "[null]";
        } else if(value instanceof Array) {
            var result = [];
            for(var i = 0; i < value.length; i++)
            {
                result.push(formatValue(row, cell, value[i], columnDef, dataContext, true));
            }
            return result.join("; ");
        } else if("object" === typeof value) {
            var result = [];
            for(var key in value) {
                if(value.hasOwnProperty(key)) {
                    var pair = key + ": " + formatValue(row, cell, value[key], columnDef, dataContext, true);
                    result.push(pair);
                }
            }
            return result.join(", ");
        } else if(value === "") {
            return "[empty]";
        } else if(isNaN(value)) {
            value = value.toString().replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
            return '"' + value.replace(/"/g, '\\"') + '"';
        } else {
            return value;
        }
    }
    function createModel(value) {
        var columns = [];
        if("object" === typeof value) {
            for(var key in value) {
                if(value.hasOwnProperty(key) && key !== "#id") {
                    columns.push({
                          id : key
                        , name : key
                        , field : key
                        , sortable: true
                        , formatter : formatValue

                        , pgvalue : false
                    });
                }
            }
        } else if(null == value) {
            columns.push({
                id : "empty",
                name : "No Records Match Your Query",
                field : "empty"
            });
        } else {
            columns.push({
                  id : "value"
                , name : "Value"
                , field : "value"
                , pgvalue : true
                , sortable: true
            });
        }
        return columns;
    }

    function transformData(model, data) {
        var result = [];
        if(model.length != 1 || !model[0].pgvalue) {
            for(var i = 0; i < data.length; i++) {
                var o = $.extend({}, data[i], { "#id" : "#" + i});
                result.push(o);
            }
        } else {
            for(var i = 0; i < data.length; i++) {
                result.push({ value : data[i], "#id" : "#" + i });
            }
        }
        return result;
    }

    function updateDataView(data, options) {
        dataView.setItems([], "#id"); // forces correct refreshes of data

        if(options && options.sort)
            sortData(data, options.sort);

        dataView.beginUpdate();
        dataView.setItems(data, "#id");
        dataView.endUpdate();
        if(options && options.pager && (("undefined" !== typeof options.pager.size) || ("undefined" !== typeof options.pager.pageNum)))
        {
            var pager = {};
            if(options.pager.size)
                pager.pageSize = options.pager.size;
            if(options.pager.page)
                pager.pageNum = options.pager.page;
            dataView.setPagingOptions(pager);
        }
    }

    function reducedResize() {
        clearInterval(this.killReducedResize);
        this.killReducedResize = setTimeout(function() {
            if(grid) grid.resizeCanvas();
        }, 0);
    }

    function sortData(data, cols) {
        data.sort(function (dataRow1, dataRow2) {
            for (var i = 0, l = cols.length; i < l; i++) {
                var field = cols[i].field;
                var sign = cols[i].asc ? 1 : -1;
                var value1 = dataRow1[field], value2 = dataRow2[field];
                var result = (value1 == value2 ? 0 : (value1 > value2 ? 1 : -1)) * sign;
                if (result != 0) {
                    return result;
                }
            }
            return 0;
        });
    }

    var changePagerHandler;
    return wrapper = {
        type : "table",
        name : "Table",
        panel : function() { return elPanel; },
        toolbar : function() {
            return $('<div></div>');
        },
        update : function(data, options) {
            if(!options) options = {};
            if(changePagerHandler)
                dataView.onPagingInfoChanged.unsubscribe(changePagerHandler);
            try {
                if(grid) grid.destroy();
            } catch(e) {}


            var model = createModel(data && data.length > 0 && data[0] || []);

            data = transformData(model, data);

            try {
                grid = new Slick.Grid(elOutput, dataView, model, gridOptions);
            } catch(e) {}

            changePagerHandler = function(e, args) {
                options.pager = { size : args.pageSize, page : args.pageNum };
                $(wrapper).trigger("optionsChanged", options);
            }

            if(options.sort) {
                grid.setSortColumns(options.sort.map(function(col){
                    return {
                        columnId : col.field,
                        sortAsc : col.asc
                    };
                }));
            }

            grid.onSort.subscribe(function (e, args) {
                options.sort = args.sortCols.map(function(def) {
                    return {
                        asc : def.sortAsc,
                        field : def.sortCol.field
                    };
                });
                $(wrapper).trigger("optionsChanged", options);
                updateDataView(data, options);
            });
            new Slick.Controls.Pager(dataView, grid, this.toolbar);

            updateDataView(data, options);

            dataView.onPagingInfoChanged.subscribe(changePagerHandler);

            reducedResize();
        },
        resize : reducedResize
    };
});