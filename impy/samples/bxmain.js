//------------------ //------------------
var isEmpty = true;
var isError = false;
var aFilesData = [];

//------------------ //------------------
function roundedRowOpenedClick(e) {
	if(BX.isNodeHidden(BX("roundedRowText"))) BX.show(BX("roundedRowText"));
	else BX.hide(BX("roundedRowText"));
};

//------------------ //------------------
function roundedRowClick(e) {
	BX("page_content_caption").innerHTML = e.innerText;
	//------------------
	if(e.id === "") {		
		BX.removeClass(BX("page_button_menu"), "work_button_menu");
		BX("page_content_result").innerHTML = "";
		isEmpty = true;
		return;
	}
	//------------------
	isEmpty = false;
	let isComp = e.id.includes("_comp_");
	BX.addClass(BX("page_button_menu"), "work_button_menu");
	//------------------
	let url = window.location.origin;
	let loc = window.location.pathname;
	loc = loc.replace("bxscripts.php", "bxmain.php");
	loc = loc.replace("bxcomponents.php", "bxmain.php");
	//------------------
	BX.ajax.loadJSON(
		url + loc + "?ajax_data=" + e.id + "&component=" + isComp,
		RebuildPage // callback функция, для результата запроса
	);
};

//------------------ //------------------
function RebuildPage(data) { 
	aFilesData = data["DATA"];
	BX("page_menu_dropdown").innerHTML = data["MENU"];
	//------------------
	if(!data["ERR"]) {
		BX("page_content_result").innerHTML = data["RESP"];	
		BX.show(BX("page_content_result"));
		BX.hide(BX("page_content_error"));
		//------------------
		if(!!data["SCRIPT"]) {
			let newScript = document.createElement('script');
			newScript.text = data["SCRIPT"];
			document.body.appendChild(newScript);
		}
	}
	else {
		let errText = "Error:<br>" + data["ERR"].replace("\n", "<br>");
		BX("page_content_error").innerHTML = errText;	
		BX.hide(BX("page_content_result"));
		BX.show(BX("page_content_error"));		
	}	
}

//------------------ //------------------
function pageContentMenuClick(e) { 
	if(isEmpty) return;
	//------------------
	let isMenuHidden = BX.isNodeHidden(BX('page_menu_dropdown'));
	if (isMenuHidden) BX.show(BX("page_menu_dropdown"));
	else BX.hide(BX("page_menu_dropdown"));	
}

//------------------ //------------------
function openMenuView(e) {
	let curFile = aFilesData.find(curData => curData.id === e.id);
	let curFileData = curFile.data
	.replaceAll("	", "&nbsp;&nbsp;&nbsp;&nbsp;")
	.replaceAll("    ", "&nbsp;&nbsp;&nbsp;&nbsp;")
	.replaceAll("<", "&lt;") .replaceAll(">", "&gt;")
	.replaceAll("\n", "<br>"); 
	//------------------
	let dialogPopup  = new BX.CDialog({
		'title': curFile.name,
		'content': curFileData,
		'draggable': true,
		'resizable': true,
		'buttons': [BX.CDialog.btnCancel]
	});
	//------------------
	BX.hide(BX("page_menu_dropdown"));
	dialogPopup.Show();
}

//------------------ //------------------
BX.ready(function() {
	BX.hide(BX("page_content_error"));
	BX.hide(BX("page_menu_dropdown"));

	//------------------ //------------------
	BX("page_body").addEventListener('click', (e) => {
		let isDdrMenu = e.target.id === "page_button_menu";
		isDdrMenu ||= e.target.id.startsWith("page_menu_");
		if(!isDdrMenu) BX.hide(BX("page_menu_dropdown"));
	});	

	//------------------ //------------------
	BX("selectButton").addEventListener('click', () => {
		dialogEntity.show();
	});	

	//------------------ //------------------
	BX("popupButton").addEventListener('click', () => {
		dialogPopup.Show();
	});

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
});
