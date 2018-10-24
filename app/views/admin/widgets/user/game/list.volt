<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
        {% if realParent == 1 or realParent == 3 %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-user-currency">
                Add New
            </button>
        {% endif %}
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">No</li>
      <li class="col-xs-2 list-group-item list">Category</li>
      <li class="col-xs-3 list-group-item list">Game</li>
      <li class="col-xs-2 list-group-item list">Parent Status</li>
      <li class="col-xs-2 list-group-item list">Status</li>
      <li class="col-xs-2 list-group-item list">Action</li>
    </ul>
    <ul class="list-inline text-center">
        <h4 class="text-center">-No data-</h4>
    </ul>
</form>