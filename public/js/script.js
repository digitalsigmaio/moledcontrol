$(document).ready(function () {
    $('.deleteItem').on('click', function () {
        if (confirm('Are you sure?')) {
        } else {
            return false;
        }
    });

    $('#artist_id').change(function (event) {
        $.get(
            'artistAlbums',
            {id: $('#artist_id').val()},
            function (data) {
                $('#album_id').html(data);
            });
    });

    $('.play').on('click', function () {
        $('.player').each(function () {
            $(this).get(0).pause();
        });
        $('.pause').hide();
        $('.play').show();
        $this = $(this);
        $this.hide();
        $this.next('.pause').show();

        $this.closest('#player').find('.player').get(0).play();
    });


    $('.pause').on('click', function () {
        $this = $(this);
        $this.hide();
        $this.prev('.play').show();
        $this.closest('#player').find('.player').get(0).pause();

    });
    
    $('#trackSearch').keyup(function () {
       var param1 = $('#category').val();
       var param2 = $(this).val();
       if(param2.length > 1){
           $.get(
               'trackSearch',
               {
                   category: param1,
                   search: param2
               },
               function (data) {
                   $('#list').html(data);
               }
           )
       }

    });

    $('#albumSearch').keyup(function () {
        var param1 = $('#category').val();
        var param2 = $(this).val();
        if(param2.length > 1){

        }
        $.get(
            'albumSearch',
            {
                category: param1,
                search: param2
            },
            function (data) {
                $('#list').html(data);
            }
        )
    });

    $('#artistSearch').keyup(function () {
        var param = $(this).val();
        if(param.length > 1){

        }
        $.get(
            'artistSearch',
            {
                search: param
            },
            function (data) {
                $('#list').html(data);
            }
        )
    });
	
	$('#category').change(function (event) {
        var value = $(this).val();
		//value = parseInt(value);
        var placeholder;
        switch (value) {
            case '0':
                placeholder = 'Search by artist';
                break;
            case '1':
                placeholder = 'Search by album';
                break;
            case '2':
                placeholder = 'Search by track';
                break;
			default: 
				placeholder = 'Search';
        }
        $('input[type=search]').attr('placeholder', placeholder);

    });

});
