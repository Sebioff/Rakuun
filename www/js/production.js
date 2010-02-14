$(".rakuun_production_item_description_content").hide();

$(".rakuun_production_item_description_toggle").click(function() {
	$(this).parent().find(".rakuun_production_item_description_content").show();
	$(this).remove();
	return false;
});