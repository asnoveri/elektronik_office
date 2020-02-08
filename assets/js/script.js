// untuk memulai jquery
$(function () {


	// tambah menu
	$("#aad_menu").on('click', function () {
		$("#label_nm").html("Tambah Menu");
		$("#menu").val("");
		$("#call_child").val("");
		$("#posisi_menu").val("");
		$("#id_menu").val("");
		$("#tbl_proses").html("SIMPAN MENU");
		$('#pom').html("");
	});

	// edit menu
	$("a[id='edit_mn']").on('click', function () {
		$("#label_nm").html('Edit Menu');
		$("#tbl_proses").html("EDIT Menu");

		//untuk mengubah form action ddan methode modal 
		$(".modal-body form").attr('action', 'http://localhost/disposisi/Menu_Managemen/edit_menu');

		//unutuk menampung id yang dikirimanan dari ahref data
		const id_menu = $(this).data('id_men');
		// console.log(id_menu);

		$.ajax({
			//untuk memangil contorller Menu_mange dan methode get_menu_byid
			url: 'http://localhost/disposisi/Menu_Managemen/get_menu_byid',
			//data yang dikirmkan
			data: {
				id_menu: id_menu
			},
			//digunakan unutk mengrim data post/get
			method: 'post',
			//type data yang dikembalikan json/text
			dataType: 'json',
			//jika suksess menerima parameter data
			success: function (data) {
				//digunakan untuk menampilkan value dari controler/ mengubah value
				$("#menu").val(data.menu);
				$("#call_child").val(data.call_child);
				$("#posisi_menu").val(data.posisi);
				$("#id_menu").val(data.id_menu);
			}
		});
	});



	//tambah sub menu
	$("#add_sb_mn").on('click', function () {
		$("#lbl_sb_mn").html("Tambah Sub Menu");
		$("#btn_sb_mn").html("Simpan Sub Menu");
		$("#sub_menu").val("");
		$("#id_menu").val("");
		$("#url").val("");
		$("#icon").val("");
		$("#posisi_sub").val("");
		$("#id_submenu").val("");
		$('#pos').html("");

	});


	//edit sub menu
	$("a[id='edit_sb_mn']").on('click', function () {
		$("#lbl_sb_mn").html("Edit Sub Menu");
		$("#btn_sb_mn").html("Edit Sub Menu");

		$(".modal-body form").attr('action', 'http://localhost/disposisi/Menu_Managemen/edit_submenu');
		const id_submenu = $(this).data('id_submn');

		$.ajax({
			url: 'http://localhost/disposisi/Menu_Managemen/get_submenu_byid',
			data: {
				id_submenu: id_submenu
			},
			method: 'post',
			dataType: 'JSON',

			success: function (data) {
				$("#sub_menu").val(data.title);
				$("#id_menu").val(data.id_menu);
				$("#url").val(data.url);
				$("#icon").val(data.icon);
				$("#posisi_sub").val(data.posisi_sub);
				$("#id_submenu").val(data.id_submenu);
			}
		});
	});


	// script untuk menampilkan url berdasarkan parent menu yang di pilih pada form sub_menu
	// on change event berjalan berdasarkan Parent menu yang di pilih
	$("#id_menu").on('change', function () {

		// const ctrl_menu menampung data value berdasarkan parent menu yang dipilih
		const ctrl_menu = $("#id_menu").val();

		$.ajax({
			url: 'http://localhost/disposisi/Menu_Managemen/get_menu_byid',
			data: {
				id_menu: ctrl_menu
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				// untuk mengubah value dari input id url
				$("#url").val(data.ctrl_menu + "/");
				// mengubah isi text p id note
				$("#note").html("Note: Tambahkan Nama Method Setelah Url Controler " + data.ctrl_menu + " Jika Ada *");
				// menambahkan css pada text p id note
				$("#note").css({
					"font-size": "12px",
					"font-style": "italic"
				});
				// menambahkan  class daro boostrap  pada isi text p id note
				$("#note").addClass("text-danger");
				$("#url").val(data.ctrl_menu + "/");
				// mengubah isi text p id note
				$("#note").html("Note: Tambahkan Nama Method Setelah Url Controler " + data.ctrl_menu + " Jika Ada *");
				// menambahkan css pada text p id note
				$("#note").css({
					"font-size": "12px",
					"font-style": "italic"
				});
				// menambahkan  class daro boostrap  pada isi text p id note
				$("#note").addClass("text-danger");
			}

		});

	});



	// cek posisi menu
	$("#posisi_menu").keyup(function () {

		const posisi_menu = $("#posisi_menu").val();
		const id_menu = $("#id_menu").val();
		$.ajax({
			url: 'http://localhost/disposisi/Menu_Managemen/cek_posisi_menu',
			data: {
				posisi_menu: posisi_menu,
				id_menu: id_menu
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				if (data != null) {
					$('#pom').html("Note: Posisi Sudah Digunakan *" + data.menu);
					$("#pom").css({
						"font-size": "12px",
						"font-style": "italic"
					});
					$("#pom").addClass("text-danger");
					$("#tbl_proses").hide("");
				} else {
					$('#pom').html("");
					$("#tbl_proses").show("");
				}
			}
		});
	});

	// mencek posisi sub menu
	$("#posisi_sub").keyup(function () {

		const posisi_sub = $("#posisi_sub").val();
		const ctrl_menu = $("#id_menu").val();

		$.ajax({
			url: 'http://localhost/disposisi/Menu_Managemen/cek_posisi_sub_menu',
			data: {
				posisi_sub: posisi_sub,
				id_menu: ctrl_menu
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				if (data != null) {
					$('#pos').html("Note: Posisi Sudah Digunakan " + data.title + "*");
					$("#pos").css({
						"font-size": "12px",
						"font-style": "italic"
					});
					$("#pos").addClass("text-danger");
					$('#btn_sb_mn').hide();
				} else {
					$('#pos').html("");
					$('#btn_sb_mn').show();
				}
			}
		});
	});

	// ubah hak akses menu
	$(".form-check-input").on('click', function () {
		const role_id = $(this).data('role');
		const id_menu = $(this).data('menu');

		$.ajax({
			url: 'http://localhost/disposisi/Menu_Managemen/ubah_access',
			type: 'post',
			data: {
				role_id: role_id,
				id_menu: id_menu
			},
			success: function () {
				//unutk meridirect dengan Ajax
				document.location.href = "http://localhost/disposisi/Menu_Managemen/cek_akses_menu/" + role_id;

			}
		});
	});

	//add admin
	$("#aad_admn").on('click', function () {
		$("#label_tbhadmin").html("Tambahkan Admin Baru");
		$("#fullname").val("").removeAttr('readonly');
		$("#email").val("").removeAttr('readonly');
		$("#pass").val("");
		$("#pass1").val("");
		$("#btn_add_admn").html("Tambahkan");
		$(".modal-dialog").removeClass("modal-sm");
		$("#nm").show();
		$("#em").show();
		$("#pase").show();
		$("#lbpas").html("Password Verification");
	});

	//edit pass admin
	$("a[id='edit_admn']").on('click', function () {
		$("#label_tbhadmin").html("Ubah Password ");
		$("#btn_add_admn").html("Edit Password");
		$(".modal-body form").attr('action', 'http://localhost/disposisi/Managemen_Admin/edit_admin');
		$(".modal-dialog").addClass("modal-dialog modal-sm");
		$("#nm").hide();
		$("#em").hide();
		$("#pase").hide();
		$("#lbpas").html("Masukan Password Baru");
		const id = $(this).data('id_admin');

		$.ajax({
			url: "http://localhost/disposisi/Managemen_Admin/get_adminBYID",
			data: {
				id: id
			},
			// type dan method memiliki fungsi yang sama
			method: 'post',
			dataType: 'JSON',
			success: function (data) {
				console.log(data);
				$("#fullname").val(data.fullname).attr('readonly', true);
				$("#email").val(data.email).attr('readonly', true);
				$("#id").val(data.id);
			}
		});
	})

	// edit pass operator
	$("a[id='tbl_editop']").on('click', function () {

		const idop = $(this).data('id_op');
		$.ajax({
			url: "http://localhost/disposisi/User_Managemen/get_operatorBYid",
			data: {
				idop: idop
			},
			method: 'POST',
			dataType: 'JSON',
			success: function (data) {
				$("#nl").hide();
				$("#em").hide();
				$("#fullnameop").val(data.fullname).attr('readonly', true);
				$("#emailop").val(data.email).attr('readonly', true);
				$("#id").val(data.id);
			}
		});
	});

	//menaktivkan dan mennonaktifkan user
	$(".status").on('change', function () {
		const val_status = $(".status").val();
		const idst = $(this).data('idst');
		const role_id = $(this).data('role_id');
		const id_user = $(this).data('id_user')
		$.ajax({
			url: 'http://localhost/disposisi/User_Managemen/ubah_isactiveUser',
			type: 'post',
			data: {
				idst: idst,
				id_user: id_user
			},
			success: function (data) {
				//unutk meridirect dengan Ajax
				document.location.href = "http://localhost/disposisi/User_Managemen/list_all_user/" + role_id;

			}
		});
	});

	//tampilkan nama file saat file upload di pilih
	$(".custom-file-input").on('change', function () {
		let filename = $(this).val().split('\\').pop();
		$(this).next(".custom-file-label").addClass("selected").html(filename);
	});
	// split('\\').pop() digunakan untuk menghilangkan tanda \\ pada val input file


	//upload edit foto
	$(":input[id='customFile']").on('change', function () {
		const form_data = new FormData($('#form_upload_foto')[0]);
		const idgambar = $("#idgambar").val();
		const role_id = $("#role_id").val();

		$.ajax({
			url: 'http://localhost/disposisi/User_Managemen/do_edit_uploadimage',
			data: form_data,
			contentType: false,
			processData: false,
			type: 'post',
			success: function (data) {
				//unutk meridirect dengan Ajax
				document.location.href = "http://localhost/disposisi/User_Managemen/edit_user/" + idgambar + "/" + role_id;

			}
		});
	})

	// meampilkan "ditersukan input yang readonly" jika tidak ingin merubah diteruskan, Jika ingin Merubah diteruskan tampilkan ditersukan yang combo box.
	// hide yang di bawah berfungis untuk menghilngkan comboboc di teruska jika program di buka
	$(".slt").hide();
	$(".cekter").on('change', function () {
		if ($(this).is(':checked')) {
			$(".diter").empty();
			$(".slt").show().attr('name', 'di_teruskan_ke');
		} else {
			console.log("not");
			document.location.href = "http://localhost/disposisi/Managemen_Surat";
		}
	});
	// membuat view file pdf
	$("a[id='fl_in_mesage']").on('click', function () {
		const pdfvw = $(".pdfview").data("pdf");
		const options = {
			height: "500px",
			width: "100%",
			pdfOpenParams: {
				view: 'FitV',
				page: '4'
			}
		};
		PDFObject.embed("http://localhost/disposisi/assets/upload_file_surat/" + pdfvw, ".pdfview", options);
	})


});
