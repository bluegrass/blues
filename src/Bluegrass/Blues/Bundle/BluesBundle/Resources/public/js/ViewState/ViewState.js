/* TODO: Esto no va aca */
jQuery.namespace = function() {
	var a=arguments, o=null, i, j, d;
	for (i=0; i<a.length; i=i+1) {
		d=a[i].split(".");
		o=window;
		for (j=0; j<d.length; j=j+1) {
			o[d[j]]=o[d[j]] || {};
			o=o[d[j]];
		}
	}
	return o;
};

jQuery.namespace('Bluegrass.Blues.Blues.ViewState');
		

Bluegrass.Blues.Blues.ViewState.ViewState = function(requestParamName, data) 
{
	this.requestParamName = requestParamName;
	this.data = data
};

Bluegrass.Blues.Blues.ViewState.ViewState.prototype.getData = function()
{
    return this.data;
};

Bluegrass.Blues.Blues.ViewState.ViewState.prototype.getRequestParamName = function()
{
    return this.requestParamName;
};

Bluegrass.Blues.Blues.ViewState.redirect = function( url, postData )
{
    var form = $("<form></form>");

    form.attr('action', url);
    form.attr('method', 'POST');
    
    var hidden = $('<input type="hidden"></input>');
    
    hidden.val(bluegrass_blues_blues_viewstate_viewstate.getData());
    hidden.attr('name', bluegrass_blues_blues_viewstate_viewstate.getRequestParamName());
    
    form.append(hidden);
    
    $('body').append(form);
    
    form.submit();
};

Bluegrass.Blues.Blues.ViewState.renderHiddenViewState = function( formId, bluegrass_blues_blues_viewstate_viewstate )
{
    var form = $("#" + formId);
    
    var hidden = $('<input type="hidden"></input>');
    
    hidden.val(bluegrass_blues_blues_viewstate_viewstate.getData());
    hidden.attr('name', bluegrass_blues_blues_viewstate_viewstate.getRequestParamName());
    hidden.appendTo(form);
    
};
