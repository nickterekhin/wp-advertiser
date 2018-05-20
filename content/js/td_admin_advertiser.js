(function($,obj){

    obj.table_obj=null;
    obj.table_options = {
        order:[],
        pageLength:50
    };
    $(document).ready(function(){

        initTable();

    });

    function initTable()
    {
        var tableId=$("#sorted_table");

        if(tableId.size()>0)
        {
            obj.table_obj = tableId.dataTable({order:obj.table_options.order,"pageLength": obj.table_options.pageLength})
        }
    }
    obj.add_filters =function(filters,table)
    {
        var _self = this,
            filters_node = $("#wp-list-table-filters");
        _self.table_obj = table || _self.table_obj;

        if(filters_node.length==0) return;
        var parent_div_length = $("#"+_self.table_obj[0].id+"_length");

        parent_div_length.after(filters_node.html());

        initFilters(this.table_obj.api(),filters);
    };

    var initFilters = function(table_api,filters)
    {
        var tableState =table_api.state.loaded();
        $.each(filters,function(i,v){
            var el = $("#"+ v.id);

            el.on('change',function(){
                var val = this.value;
                table_api.columns(v.column).search(val?'(,|^)'+val+'(,|$)':'',true,false).draw();

            });

            //use state values
            if (typeof tableState !== 'undefined' && tableState != null) {
                var column = tableState.columns[v.column];
                var search_val = column.search.search;
                if (!isEmpty(search_val)) {
                    var found = search_val.match(/\)(.*?)\(/i);
                    if (found) {
                        el.find('option[value="' + found[1] + '"]').attr('selected', 'true');
                    }

                }
            }
        });

    };

})(jQuery,window.admin_ads = window.admin_ads||{});