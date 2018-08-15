/**
* js-модуль для вставки формы выбора почтового терминала QiwiPost для сайтов, работающих на платформе VamShop
* @author Zoya Schegolihina zoya (at) qiwipost (dot) ru
*
*/
var Qiwipost = {};
jQuery( function($) {
	Qiwipost = {
		/* Ссылка на карту */
		getlink: function(){
			return '<a href="javascript:void(0);" class="qiwipost_link">Выбрать почтомат на карте</a>';
		},
		/* Задаем объекты, с которыми будет работать виджет */
		vars: function(){
			/* radio-кнопка QIWI Post */
			this.radio 			= $('input:radio[name="shipping"][value^="qiwipost_qiwipost"]');
			/* все radio-кнопки с выбором доставки */
			this.radios 		= $( 'input:radio[name="shipping"]' );
		},
		/* Вызов всплывающего окна с картой */
		map: function(){
			openMap();
		},
		/* обновляет combobox на нужный адрес после выбора на карте */
		map_callback: function ( d )
		{			Qiwipost.vars();			d = d.split( ';' );
			if ( $( '#qiwipost_terminal option[value="'+d[0]+'"]' ).get().length > 0 )
			{
				Qiwipost.refr();
			}
			else
			{
				alert('Терминала с номером '+d[0]+' нет в списке. Для получения заказа в терминале '+d[0]+' вам необходимо первоначально изменить регион в адресе доставки.');
			}
		},
		isQiwiPost: function(){			Qiwipost.vars();
			return Qiwipost.radio.is( ':checked' );
		},
		refr: function(){			Qiwipost.vars();
			Qiwipost.radio.attr( 'checked', 'checked' );
			if ( Qiwipost.isQiwiPost() )
			{
				var url='checkout.php';
				$('#shipping_options').load(url +' #shipping_options > *', {'shipping': $('input[name=shipping]:checked').val(),'payment': $('input[name=payment]:checked').val(), 'qiwipost_terminal': $('#qiwipost_terminal').val()}, function(){$('#shipping_modules_box').trigger('refresh');});
			}
		}
	};
	Qiwipost.vars();
	/* Вешаем обработчик события при клике по ссылке "показать карту" */
	$('a.qiwipost_link').live('click', Qiwipost.map);

	/* Вешаем обработчик события на изменение терминала в выпадающем списке */
	$( '#qiwipost_terminal' ).live( 'change', function(){
		Qiwipost.refr();
	} );
});