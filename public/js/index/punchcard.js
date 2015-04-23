$(document).ready(function() {
    $('span[data-ip]').simpletip({
	content: "",
	fixed: true,
	persistent: true,
	onBeforeShow: function(){
	    if(this.loaded)return;
	    this.load("/host/punchcard/"+this.getParent().attr('data-ip'));
	    this.loaded = true;
	}
    });
    $('span[data-ip]').children('img').click(function(){
	$(this).parent().click();
    });
});