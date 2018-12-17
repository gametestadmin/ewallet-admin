<!-- Modal -->
<div class="modal fade" id="form-user-currency" tabindex="-1" role="dialog" aria-labelledby="form-user-currency-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('downline/currency/add')}}" method="post" id="form">
                <div class="modal-header">
                    <label class="col-xs-6">
                        <h3 class="modal-title" id="form-user-currency-label">{{translate['title_text_add_currency']}}</h3>
                    </label>
                    <label class="col-xs-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </label>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">{{translate['form_currency']}}</label>
                        <label class="col-xs-9">
                            <input type="hidden" name="user" value="{{agent.id}}">
                            <select name="currency" class="form-control">
                                <option value="">{{translate['form_choose_one']}}</option>
                                {% for currencyData in currency %}
                                    <option value="{{currencyData.id}}">{{currencyData.nm}}</option>
                                {% endfor %}
                            </select>
                            <input type="hidden" name="tab" value="tab-currency">
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate['button_close']}}</button>
                    <button type="submit" class="btn btn-primary" id="submit">{{translate['button_add']}}</button>
                </div>
            </form>
        </div>
    </div>
</div>