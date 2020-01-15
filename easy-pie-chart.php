<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="assets/js/jquery.easypiechart.js"></script>
<script>
$(function() {
	$('.chart').easyPieChart({
		easing: 'easeOutBounce',
		onStep: function(from, to, percent) {
			$(this.el).find('.percent').text(Math.round(percent));
		}
	});
	var chart = window.chart = $('.chart').data('easyPieChart');
	$('.js_update').on('click', function() {
		chart.update(Math.random()*200-100);
	});
});
</script>