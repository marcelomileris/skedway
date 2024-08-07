var User = (function () {
	var initValidationUser = function () {
		jQuery(".form-user").validate({
			rules: {
				txtName: {
					required: true,
				},
				txtEmail: {
					required: true,
				},
				txtPass: {
					required: true,
				},
			},
			messages: {
				txtName: {
					required: "Nome requerido",
				},
				txtEmail: {
					required: "Email requerido",
				},
				txtPass: {
					required: "Senha requerida",
				},
			},
			submitHandler: function () {
				var user_id = $("#txtID").val();
				var name = $("#txtName").val();
				var email = $("#txtEmail").val();
				var pass = $("#txtPass").val();
				$.ajax({
					method: "POST",
					url: base_url + "painel/add",
					data: {
						user_id: user_id,
						name: name,
						email: email,
						pass: pass,
					},
					success: function (res) {
						clearFields();
						$("#frmUser").modal("toggle");
						loadData();
					},
					error: function (request, status, error) {
						console.log(error);
					},
				});
			},
		});
	};
	return {
		init: function () {
			initValidationUser();
		},
	};
})();

var loadData = function () {
	$.ajax({
		method: "POST",
		url: base_url + "painel/data",
		success: function (res) {
			res = JSON.parse(res);
			if (res.length > 0) {
				createTable(res);
			} else {
				$("#tableUser tbody").empty();
			}
		},
		error: function (request, status, error) {
			console.log(error);
		},
	});
};

var createTable = function (res) {
	table = "";
	$.each(res, function (i, item) {
		var active = item.active == "1" ? "checked" : "";
		var admin = item.admin == "1" ? "checked" : "";

		table += `<tr>
                    <td class='text-center align-middle'>${item.id.padStart(
						6,
						"0"
					)}</td>
                    <td class='align-middle'>${item.created}</td>
                    <td class='align-middle'>${item.name}</td>
                    <td class='align-middle'>${item.email}</td>
                    <td class='align-middle'>******</td>
					<td class='align-middle'>${item.address}</td>
					<td class='align-middle'>${item.number}</td>
					<td class='align-middle'>${item.zipcode}</td>
                    <td class='text-center align-middle'> 
                        <input type="checkbox" ${active} data-id="${
			item.id
		}" class="chkActive"/>
                    </td>
                    <td class='text-center align-middle'> 
                        <input type="checkbox" ${admin} data-id="${
			item.id
		}" class="chkAdmin"/>
                    </td>
                    <td class='text-center align-middle'>
                        <div class="btn-group">
                            <button class="btn excluir" type="button" data-id="${
								item.id
							}"><i class="fa fa-trash"></i></button>
                            <button class="btn editar" type="button" data-id="${
								item.id
							}"><i class="fa fa-edit"></i></button>
                        </div>
                    </td>
                </tr>`;
	});
	$("#tableUser tbody").empty();
	$("#tableUser tbody").hide().append(table).fadeIn("slow");
};

var active = function () {
	$(document).on("change", ".chkActive", function () {
		var id = $(this).data("id");
		var active = $(this).is(":checked") == true ? 1 : 0;
		$.ajax({
			method: "POST",
			url: base_url + "painel/active",
			data: {
				user_id: id,
				active: active,
			},
			success: function (res) {
				console.log(res);
			},
			error: function (request, status, error) {
				console.log(error);
			},
		});
	});
};

var active = function () {
	$(document).on("change", ".chkAdmin", function () {
		var id = $(this).data("id");
		if (id == "1") {
			message(
				"Não é possível remover o perfil de administrador do usuário"
			);
			$(this).prop("checked", true);
		} else {
			var admin = $(this).is(":checked") == true ? 1 : 0;
			$.ajax({
				method: "POST",
				url: base_url + "painel/admin",
				data: {
					user_id: id,
					admin: admin,
				},
				success: function (res) {
					console.log(res);
				},
				error: function (request, status, error) {
					console.log(error);
				},
			});
		}
	});
};

var del = function () {
	$(document).on("click", ".excluir", function () {
		var id = $(this).data("id");

		$.confirm({
			type: "red",
			title: "Atenção!",
			content: "Confirma exclusão do usuário?",
			buttons: {
				YES: {
					text: "Sim",
					btnClass: "btn-red",
					action: function () {
						$.ajax({
							method: "POST",
							url: base_url + "painel/delete",
							data: {
								user_id: id,
							},
							success: function (res) {
								loadData();
							},
							error: function (request, status, error) {
								console.log(error);
							},
						});
					},
				},
				NO: {
					text: "Não",
				},
			},
		});
	});
};

var edit = function () {
	$(document).on("click", ".editar", function () {
		var id = $(this).data("id");
		$.ajax({
			method: "POST",
			url: base_url + "painel/get",
			data: {
				user_id: id,
			},
			success: function (res) {
				res = JSON.parse(res);
				$("#txtID").val(res[0].id);
				$("#txtName").val(res[0].name);
				$("#txtEmail").val(res[0].email);
				$("#txtPass").val(res[0].pass);
				$("#frmUser").modal("toggle");
			},
			error: function (request, status, error) {
				console.log(error);
			},
		});
	});
};

var clearFields = function () {
	$("#txtID").val("");
	$("#txtName").val("");
	$("#txtEmail").val("");
	$("#txtPass").val("");
};

$(document).ready(function () {
	User.init();
	loadData();
	active();
	del();
	edit();

	$("#frmUser").on("hide.bs.modal", function () {
		clearFields();
	});

	$("#frmUser").on("shown.bs.modal", function () {
		$("#txtName").trigger("focus");
	});

	$("#btnLogout").click(function () {
		window.location.href = base_url + "painel/logout";
	});
});
