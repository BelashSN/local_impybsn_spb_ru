
	BX.ready(function(){
		//var selector = new BX.UI.EntitySelector.TagSelector(options);
		//var dialog = new BX.UI.EntitySelector.Dialog(options);

		//------------------ //------------------
		const selectButton = document.getElementById('selectButton');
		const popupButton = document.getElementById('popupButton');

		//------------------ //------------------
		var dialogEntity = new BX.UI.EntitySelector.Dialog({
			targetNode: selectButton,
			context: 'MY_PAGE_CONTEXT',
			enableSearch: true,
			searchOptions: {
					allowCreateItem: false
			}, 
			multiple: false,
			entities: [
				{
					id: 'contact',
					dynamicLoad: true,
					dynamicSearch: true
				},
			],
		});

		//------------------ //------------------
		var dialogPopup  = new BX.CDialog({
			'title': 'Заголовок окна',
			'content': 'Текст внутри окна',
			'draggable': true,
			'resizable': true,
			'buttons': [BX.CDialog.btnSave, BX.CDialog.btnCancel]
		});

		//------------------ //------------------
		selectButton.addEventListener('click', () => {
			dialogEntity.show();
		});	

		//------------------ //------------------
		popupButton.addEventListener('click', () => {
			dialogPopup.Show();
		});
	});
