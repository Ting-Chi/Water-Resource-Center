$(document).ready(function() {
    // 一旦頁面已載入，就移除載入動畫
    $('.loading').remove();

    // tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // 整體分析
    $('.round-chart').easyPieChart({
        'scaleColor': false,
        'lineWidth': 20,
        'lineCap': 'butt',
        'barColor': '#6d5cae',
        'trackColor': '#e5e9ec',
        'size': 190
    });

    
    // 自訂核取方塊
    var elems, switcheryOpts;

    elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'))

    switcheryOpts = {
        color: '#1bc98e'
    };

    elems.forEach(function(el) {
        var switchery = new Switchery(el, switcheryOpts);
    });

   
    // 即時資訊
    changeMultiplier = 0.2;
    window.setInterval(function() {
      var freeSpacePercentage;

      freeSpacePercentage = $('#free-space').text();
      freeSpacePercentage = parseFloat(freeSpacePercentage);

      delta = changeMultiplier * (Math.random() < 0.5 ? -1.0 : 1.0);

      freeSpacePercentage = freeSpacePercentage + freeSpacePercentage * delta;
      freeSpacePercentage = parseInt(freeSpacePercentage);

      $('#free-space').text(freeSpacePercentage + '%');
    }, 2000);

    

    $('#search-icon').on('click', function(e) {
        e.preventDefault();
        $('form#search').slideToggle('fast');
        $('form#search input:first').focus();
    });

    $('form#search input').on('blur', function(e) {
        if($('#search-icon').is(':visible')) {
            $('form#search').slideUp('fast');
        }
    });
});
