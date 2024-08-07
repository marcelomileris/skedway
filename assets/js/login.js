var Login = (function () {
	var initValidationLogin = function () {
		jQuery("#form-signin").validate({
			rules: {
				email: {
					required: true,
				},
				pass: {
					required: true,
				},
			},
			messages: {
				email: {
					required: "E-mail requerido",
				},
				pass: {
					required: "Senha requerida",
				},
			},
			submitHandler: function () {
				var email = $("#email").val();
				var pass = $("#pass").val();
				$.ajax({
					method: "POST",
					url: base_url + "login/login",
					data: {
						email: email,
						pass: pass,
					},
					success: function (res) {
						res = JSON.parse(res);
						if (res.success == false) {
							message(
								"Não foi possível realizar o login, verifique seu usuário e senha!"
							);
						} else {
							window.location.href = "painel/";
						}
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
			// Init Login Form Validation
			initValidationLogin();
		},
	};
})();

var Register = (function () {
	var initValidationRegister = function () {
		jQuery("#form-register").validate({
			rules: {
				newname: {
					required: true,
				},
				newemail: {
					required: true,
				},
				newpass: {
					required: true,
				},
				zipcode: {
					required: true,
				},
				address: {
					required: true,
				},
				number: {
					required: true,
				},
			},
			messages: {
				newname: {
					required: "Qual o seu nome?",
				},
				newemail: {
					required: "Qual o seu e-mail?",
				},
				newpass: {
					required: "Crie uma senha",
				},
				zipcode: {
					required: "Informe o Cep",
				},
				address: {
					required: "Informe seu endereço",
				},
				number: {
					required: "Informe o número",
				},
			},
			submitHandler: function () {
				var name = $("#newname").val();
				var email = $("#newemail").val();
				var pass = $("#newpass").val();
				var zipcode = $("#zipcode").val();
				var address = $("#address").val();
				var number = $("#number").val();
				$.ajax({
					method: "POST",
					url: base_url + "login/register",
					data: {
						name: name,
						email: email,
						pass: pass,
						zipcode: zipcode,
						address: address,
						number: number,
					},
					success: function (res) {
						console.log(res);
						res = JSON.parse(res);
						if (res.success == false) {
							msg = res.msg;
							message(
								`Não foi possível realizar o cadastro. ${msg}!`
							);
						} else {
							message("Usuário cadastrado com sucesso!");
							$("#newname").val("");
							$("#newemail").val("");
							$("#newpass").val("");
							$("#newname").focus();
							$("#zipcode").val("");
							$("#address").val("");
							$("#number").val("");
						}
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
			initValidationRegister();
		},
	};
})();

var register = function () {
	$("#btnRegister").click(function () {
		$("#formContent").hide("fast");
		$("#formRegister").show("slow");
		$("#email").focus();
	});
};

var login = function () {
	$("#btnLogin").click(function () {
		$("#formRegister").hide("fast");
		$("#formContent").show("slow");
		$("#newname").focus();
	});
};

var getAddress = function () {
	$("#zipcode").blur(function () {
		var zipcode = $("#zipcode").val();
		$.ajax({
			method: "POST",
			url: base_url + `painel/getaddress/${zipcode}`,
			data: {
				zipcode: zipcode,
			},
			success: function (res) {
				console.log(res);
				res = JSON.parse(res);
				if (res.success == false) {
					msg = res.msg;
					message(`Não foi possível realizar o cadastro. ${msg}!`);
				} else {
					$("#address").val(
						`${res.data.logradouro}, ${res.data.bairro}, ${res.data.localidade}/${res.data.uf}`
					);
					$("#number").focus();
				}
			},
			error: function (request, status, error) {
				console.log(error);
			},
		});
	});
};

var validateZipCode = function () {
	var value = $("#zipcode").val();
	console.log(value);
	if (!value) return "";
	value = value.replace(/\D/g, "");
	value = value.replace(/(\d{5})(\d)/, "$1-$2");
	$("#zipcode").val(value);
};

$(document).ready(function () {
	$("#email").focus();
	register();
	login();
	getAddress();
	validateZipCode();
	Login.init();
	Register.init();
});
