<!-- Modal -->
<div class="modal fade" id="form-user-currency" tabindex="-1" role="dialog" aria-labelledby="form-user-currency-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('agent/currency/add')}}" method="post" id="form">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Currency</label>
                        <lable class="col-xs-9">
                            <input type="hidden" name="user" value="{{agent.id}}">
                            <select name="currency" class="form-control">
                                <option value="">-Choose One-</option>
                                {% for currencyData in currency %}
                                    <option value="{{currencyData.currency.id}}">{{currencyData.currency.name}}</option>
                                {% endfor %}
                            </select>
                            <input type="hidden" name="tab" value="tab-currency">
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>