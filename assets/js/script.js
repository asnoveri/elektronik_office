// untuk memulai jquery
$(function () {
	const url = $("#page-top").data('url');

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
		$(".modal-body form").attr('action', url + 'Menu_Managemen/edit_menu');

		//unutuk menampung id yang dikirimanan dari ahref data
		const id_menu = $(this).data('id_men');
		// console.log(id_menu);


		$.ajax({
			//untuk memangil contorller Menu_mange dan methode get_menu_byid
			url: url + 'Menu_Managemen/get_menu_byid',
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
		$(".modal-body form").attr('action', url + 'Menu_Managemen/edit_submenu');
		const id_submenu = $(this).data('id_submn');
		console.log(id_submenu);
		$.ajax({
			url: url + 'Menu_Managemen/get_submenu_byid',
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
			url: url + 'Menu_Managemen/get_menu_byid',
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
			url: url + 'Menu_Managemen/cek_posisi_menu',
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
			url: url + 'Menu_Managemen/cek_posisi_sub_menu',
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
			url: url + 'Menu_Managemen/ubah_access',
			type: 'post',
			data: {
				role_id: role_id,
				id_menu: id_menu
			},
			success: function () {
				//unutk meridirect dengan Ajax
				document.location.href = url + "Menu_Managemen/cek_akses_menu/" + role_id;

			}
		});
	});

	//tampilkan nama file saat file upload di pilih
	$(".custom-file-input").on('change', function () {
		let filename = $(this).val().split('\\').pop();
		// split('\\').pop() digunakan untuk menghilangkan tanda \\ pada val input file
		$(this).next(".custom-file-label").addClass("selected").html(filename);
	});

	//upload edit foto
	$(":input[id='customFile']").on('change', function () {
		const form_data = new FormData($('#form_upload_foto')[0]);
		const idgambar = $("#idgambar").val();

		$.ajax({
			url: url + 'User_Managemen/do_edit_uploadimage',
			data: form_data,
			contentType: false,
			processData: false,
			type: 'post',
			success: function (data) {
				//unutk meridirect dengan Ajax
				document.location.href = url + "User_Managemen/edit_user/" + idgambar;
				// console.log(data);
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
			document.location.href = url + "Managemen_Surat";
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
		PDFObject.embed(url + "assets/upload_file_surat/" + pdfvw, ".pdfview", options);
	})


	//mengubah fedback ketika mengklik alert srt masuk
	$(".ubah_feedback").on('click', function () {
		const id_terus = $(this).data('id_terus_srt_msk');
		$.ajax({
			url: url + 'User/ubh_feedback_srtmsk_user',
			type: 'post',
			data: {
				id_terus: id_terus
			},
			success: function (data) {
				//unutk meridirect dengan Ajax
				// document.location.href = "http://localhost/disposisi/User_Managemen/list_all_user/" + role_id;
				console.log(data);
			}
		});
	});

	$(".ubah_feedback1").on('click', function () {
		const id_terus = $(this).data('id_terus_srt_msk');
		$.ajax({
			url: url + 'User/ubh_feedback_srtmsk_user',
			type: 'post',
			data: {
				id_terus: id_terus
			},
			success: function (data) {
				//unutk meridirect dengan Ajax
				// document.location.href = "http://localhost/disposisi/User_Managemen/list_all_user/" + role_id;
				console.log(data);
			}
		});
	});

	// mengubah feedback ketika mengklik alert surat keluar
	$(".ubah_feedback_sk").on('click', function () {
		const id_terus_srt_keluar = $(this).data('id_terus_srt_klr');
		const id_surat_keluar = $(this).data('id_surat_keluar');

		$.ajax({
			url: url + 'User/ubh_feedback_srtklr_user',
			type: 'post',
			data: {
				id_terus_srt_keluar: id_terus_srt_keluar,
				id_surat_keluar: id_surat_keluar
			},
			success: function (data) {
				//unutk meridirect dengan Ajax
				// document.location.href = "http://localhost/disposisi/User_Managemen/list_all_user/" + role_id;
				console.log(data);
			}
		});
	});

	// mengubah feedback ketika mengklik alert surat keluar admin op
	$(".ubah_feedback_skopadmn").on('click', function () {
		const id_terus_srt_keluar = $(this).data('id_terus_srt_klr');
		const id_surat_keluar = $(this).data('id_surat_keluar');
		$.ajax({
			url: url + 'Managemen_Surat/ubh_feedback_srtklr_useradmop',
			type: 'post',
			data: {
				id_terus_srt_keluar: id_terus_srt_keluar,
				id_surat_keluar: id_surat_keluar
			},
			success: function (data) {
				//unutk meridirect dengan Ajax
				// document.location.href = "http://localhost/disposisi/User_Managemen/list_all_user/" + role_id;
				console.log(data);
			}
		});
	});

	// costume date time picker js
	$('#datetimepicker').datetimepicker({
		i18n: {
			de: {
				months: [
					'Januari', 'Februari', 'Maret', 'April',
					'Mai', 'Juni', 'Juli', 'Augustus',
					'September', 'Oktober', 'November', 'Desember',
				],
				dayOfWeek: [
					"So.", "Mo", "Di", "Mi",
					"Do", "Fr", "Sa.",
				]
			}
		},
		timepicker: false,
		format: 'd-m-Y'
	});
	$('#datetimepicker1').datetimepicker({
		i18n: {
			de: {
				months: [
					'Januari', 'Februari', 'Maret', 'April',
					'Mai', 'Juni', 'Juli', 'Augustus',
					'September', 'Oktober', 'November', 'Desember',
				],
				dayOfWeek: [
					"So.", "Mo", "Di", "Mi",
					"Do", "Fr", "Sa.",
				]
			}
		},
		timepicker: false,
		format: 'Y-m-d'
	});

});

// buat tooltip
$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});

//filter list surat masuk user dengan text input
$(function () {
	$("#myInput").on("keyup", function () {
		const value = $(this).val().toLowerCase();
		$("#myList ").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});

//filter list surat masuk user dengan date input
$(function () {
	$("#datetimepicker").on("change", function () {
		const value = $(this).val().toLowerCase();
		console.log(value);
		$("#myList ").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});

// list Penjabat
$(function () {
	const url = $("#page-top").data('url');
	$('#tabl_jbtn').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/penjabat/listpjbt',
			type: 'POST'
		},
	});
});

// list adum data tabel
$(function () {
	const url = $("#page-top").data('url');
	$('#tabl_adum').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/Adum/listadum',
			type: 'POST'
		},
	});
});

// list user data tabel
$(function () {
	const url = $("#page-top").data('url');
	$('#example').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/index/listuser',
			type: 'POST'
		},
	});
});

//list wadir
$(function () {
	const url = $("#page-top").data('url');
	$('#tabl_wadir').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/listwadir/listwadir',
			type: 'POST'
		},
	});
});

//list sekretaris tabel
$(function () {
	const url = $("#page-top").data('url');
	$('#tabl_sekre').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/list_op/listoprator',
			type: 'POST'
		},
	});
});

// list admin tabel
$(function () {
	const url = $("#page-top").data('url');
	$('#listAdmin').DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'Managemen_Admin/index/get_admin',
			type: 'post'
		}
	});
});

// list direktur
$(function () {
	const url = $("#page-top").data('url');
	$("#tabl_dirut").DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/listdirektur/listdirek',
			type: 'post'
		},
	});
});

// list Admin Kepegawaiaan
$(function () {
	const url = $("#page-top").data('url');
	$("#tabl_admn_kep").DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'Managemen_Admin/admn_kep/listadmnkepeg',
			type: 'post'
		},
	});
});

//list pegawai
$(function () {
	const url = $("#page-top").data('url');
	$("#tabl_pegawai").DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'User_Managemen/list_pegawai/data_pegawai',
			type: 'post'
		},
	});
});
// change status user NON aktiv
$(document).on('click', '.sel2', function () {
	const url = $("#page-top").data('url');
	const status = 0;
	const id = $(this).data('id');
	$.ajax({
		url: url + 'User_Managemen/ubah_isactiveUser',
		type: 'post',
		data: {
			id: id,
			status: status
		},
		success: function (data) {
			//unutk meridirect dengan Ajax
			document.location.href = url + "/User_Managemen";
			// console.log(data);
		}
	});
});

// change status user aktiv
$(document).on('click', '.sel1', function () {
	const url = $("#page-top").data('url');
	const status = 1;
	const id = $(this).data('id');;
	$.ajax({
		url: url + 'User_Managemen/ubah_isactiveUser',
		type: 'post',
		data: {
			id: id,
			status: status
		},
		success: function (data) {
			//unutk meridirect dengan Ajax
			document.location.href = url + "/User_Managemen";
			// console.log(data);
		}
	});
});

//add_user
$(document).on('click', '#aad_user', function () {
	const url = $("#page-top").data('url');
	// $('#tbhuser').modal('show');
	$("#label_Tambah").html("Tambah User");
	$("#fullname").show();
	$("#user_name").show();
	$("#email").show();
	$("#nip").show();
	$(".modal-dialog").removeClass(" modal-sm");
	$('#tbhuser').modal('show');
	$('#id').hide();
	$(".modal-body form").attr('action', url + 'User_Managemen/add_user');
	$('#tbl_proses').html('Tambah');
});

// edit pass user
$(document).on('click', '.edtpswd', function () {
	const url = $("#page-top").data('url');
	const id = $(this).data('id');
	$("#label_Tambah").html("Edit Kata Sandi");
	$("#fullname").hide();
	$("#user_name").hide();
	$("#email").hide();
	$("#nip").hide();
	$(".modal-dialog").addClass("modal-dialog modal-sm");
	$('#tbhuser').modal('show');
	$('#id').val(id);
	$(".modal-body form").attr('action', url + 'User_Managemen/ubahaPswd');
	$('#tbl_proses').html('Edit');
});

// tambah admin
$(function () {
	const url = $("#page-top").data('url');
	$("#aad_admn").on('click', function () {
		$("#adminModal").modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true

			}
		});
	});
});

//tambah admin kepegawaiaan
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhadmkep").on('click', function () {
		$("#modal_admn_kep").modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true

			}
		});
	});
});


// tambah Wadir
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhwadir").on('click', function () {
		$("#modal_wadir").modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});

		$('#sel2').select2({
			ajax: {
				url: url + 'User_Managemen/get_allwadir_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
	});
});

// tambah direktur
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhdirut").on('click', function () {
		$("#modal_dirut").modal('show');
		$(".modal-body form").attr('action', url + 'User_Managemen/addDirektur');
		$(".modal-body form").attr('method', 'post');
		$("#sel1").select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
	});
});

//tambah sekretaris
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhsekre").on('click', function () {
		$('#modal_skre').modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				// delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true

			}
		});
	});
});

//tambah adum
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhadum").on('click', function () {
		$('#modal_adum').modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
	});
});

//tambah pegawai
$(function () {
	const url = $("#page-top").data('url');
	$("#tbhpegawai").on('click', function () {
		$('#modal_pegawai').modal('show');
		$('#sel1').select2({
			ajax: {
				url: url + 'User_Managemen/get_alluser_combobox',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$("#sel3").select2({
			// maximumSelectionLength: 2,
			// placeholder: "Pilih Unit Kerja",
			// allowClear: true,
			ajax: {
				url: url + 'User_Managemen/get_allUnit_kerja',
				method: 'post',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$("#sel3").on('change', function () {
			$("#sel4").select2({
				ajax: {
					url: url + 'User_Managemen/get_alljabatan',
					method: 'post',
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							unitker: $("#sel3").val(),
							searchTerm: params.term,
						};
					},
					processResults: function (response) {
						return {
							results: response
						};
					},
					cache: true
				}
			});
		});
	});
});





$(function () {
	// modal absensi masuk
	$("#absen-masuk").on("click", function (e) {
		e.preventDefault();
		$("#modal_absn").modal({
			backdrop: "static",
			keyboard: true,
		});
	});

	// input absensi masuk 
	$("#btn-kirim").click(function () {
		const url = $("#page-top").data('url');
		const role_id = $("#role_id").val();

		if (role_id == 2) {
			var link = 'Operator/index/add_absensi';
		} else if (role_id == 4) {
			var link = 'Direktur/index/add_absensi';
		} else if (role_id == 5) {
			var link = 'Wadir/index/add_absensi';
		} else if (role_id == 6) {
			var link = 'Adum/index/add_absensi';
		} else if (role_id == 3) {
			var link = 'User/index/add_absensi';
		}

		const ket_keberadaan = $("#sel-keberadaan").val();
		const id_jdwlabnsi = $("#id_jadwal").val();
		const d = new Date();
		const h = d.getHours();
		const m = d.getMinutes();
		const s = d.getSeconds();
		const jam = h + ':' + m + ':' + s;
		$.ajax({
			url: url + link,
			data: {
				ket_keberadaan: ket_keberadaan,
				id_jdwlabnsi: id_jdwlabnsi,
				absensi_masuk: jam,
			},
			type: 'POST',
			dataType: 'JSON',
			success: function (data, status) {
				if (status == 'success') {
					$("#pesan-eror").addClass("alert alert-primary alert-dismissible");
					$("#pesan-eror").html(data);
					$("#pesan-eror").fadeIn(function () {
						$("#pesan-eror").fadeOut(5000);
					});
				}
			},
		});
	});

	// input absensi pulang 
	$("#absen-pulang").click(function (e) {
		e.preventDefault();
		const url = $("#page-top").data('url');
		const jk = $(".jk").data('id');
		const role_id = $(".jk").data('role');

		if (role_id == 2) {
			var link = 'Operator/index/add_absn_plng';
		} else if (role_id == 4) {
			var link = 'Direktur/index/add_absn_plng';
		} else if (role_id == 5) {
			var link = 'Wadir/index/add_absn_plng';
		} else if (role_id == 6) {
			var link = 'Adum/index/add_absn_plng';
		} else if (role_id == 3) {
			var link = 'User/index/add_absn_plng';
		}


		const d = new Date();
		const h = d.getHours();
		const m = d.getMinutes();
		const s = d.getSeconds();
		const jam = h + ':' + m + ':' + s;
		if (jam >= jk) {
			$.ajax({
				url: url + link,
				data: {
					absen_keluar: jam,
				},
				type: 'post',
				dataType: 'JSON',
				success: function (data) {
					$("#pesan-eror").addClass("alert alert-info alert-dismissible");
					$("#pesan-eror").html(data);
					$("#pesan-eror").fadeIn(function () {
						$("#pesan-eror").fadeOut(5000);
					});
				}
			});
		} else {
			$("#pesan-eror").addClass("alert alert-info alert-dismissible");
			$("#pesan-eror").html("Belum Bisa Mengambil Absen Pulang");
			$("#pesan-eror").fadeIn(function () {
				$("#pesan-eror").fadeOut(5000);
			});
		}
	});


})


setTimeout(jam_digital(), 1000);
// jam digit
function jam_digital() {
	const d = new Date();
	setTimeout("jam_digital()", 1000);
	const h = d.getHours();
	const m = d.getMinutes();
	const s = d.getSeconds();
	const jam = h + ':' + m + ':' + s;
	$('#jam').html(jam);
	$('#jam').css('font-size', '12px');
	$('#tgl').css('font-size', '12px');
}

//tampil info keberadaan dashboar admin kepegawaiaan
tampil_ikeb();

function tampil_ikeb() {
	const url = $("#page-top").data('url');
	// setInterval("tampil_ikeb()", 10000);
	$.ajax({
		url: url + "Admin_kepeg/index/get_keb",
		method: 'post',
		dataType: 'json',
		success: function (data, status) {
			$("#wfh").html(data.wfh);
			$("#pkt").html(data.pkt);
			$("#izn").html(data.izn);
			$("#jml_peg").html(data.jml_peg);
			$("#dl").html(data.dl);
			console.log(data);
		},
	});
}



$(function () {
	const url = $("#page-top").data('url');

	$('.waktu_absen').datetimepicker({
		i18n: {
			de: {
				months: [
					'Januari', 'Februari', 'Maret', 'April',
					'Mai', 'Juni', 'Juli', 'Augustus',
					'September', 'Oktober', 'November', 'Desember',
				],
				dayOfWeek: [
					"So.", "Mo", "Di", "Mi",
					"Do", "Fr", "Sa.",
				]
			}
		},
		timepicker: false,
		format: 'Y-m-d'
	});
});



// list tabel absensi perhari
$(function () {

	const url = $("#page-top").data('url');
	$("#data_absensi").DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		"ajax": {
			url: url + 'Admin_kepeg/index/list_absensi',
			type: 'post'
		},
	});
});

// list absensi by filter tanggal
$(document).ready(function () {
	const url = $("#page-top").data('url');
	const table = $("#tbl_absensi_all").DataTable({
		"pageLength": 10,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'Absensi/index/getlist_all_absensi',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});

});

// tabel absensi user adum
$(function () {
	const url = $("#page-top").data('url');
	const table = $("#tbl_absensi_forUser_adum").DataTable({
		"pageLength": 5,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'Adum/getAbsensiUser_id',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate1').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});
});



// tabel absensi user wadir
$(function () {
	const url = $("#page-top").data('url');
	const table = $("#tbl_absensi_forUser_wadir").DataTable({
		"pageLength": 5,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'Wadir/getAbsensiUser_id',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate1').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});
});


// tabel absensi user pegawai
$(function () {
	const url = $("#page-top").data('url');
	const table = $("#tbl_absensi_forUser_peg").DataTable({
		"pageLength": 5,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'User/getAbsensiUser_id',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate1').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});
});


// tabel absensi user direktur
$(function () {
	const url = $("#page-top").data('url');
	const table = $("#tbl_absensi_forUser_dirut").DataTable({
		"pageLength": 5,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'Direktur/getAbsensiUser_id',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate1').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});
});



// cetak persensi perhari dan perbulan.
$(function () {
	const url = $("#page-top").data('url');
	$('#tgl_absen_cetak').datetimepicker({
		i18n: {
			de: {
				months: [
					'Januari', 'Februari', 'Maret', 'April',
					'Mai', 'Juni', 'Juli', 'Augustus',
					'September', 'Oktober', 'November', 'Desember',
				],
				dayOfWeek: [
					"So.", "Mo", "Di", "Mi",
					"Do", "Fr", "Sa.",
				]
			}
		},
		timepicker: false,
		format: 'Y-m-d'
	});

	$('#tgl_absen_cetak1').datetimepicker({
		i18n: {
			de: {
				months: [
					'Januari', 'Februari', 'Maret', 'April',
					'Mai', 'Juni', 'Juli', 'Augustus',
					'September', 'Oktober', 'November', 'Desember',
				],
				dayOfWeek: [
					"So.", "Mo", "Di", "Mi",
					"Do", "Fr", "Sa.",
				]
			}
		},
		timepicker: false,
		format: 'Y-m-d'
	});

	// cetak perhari
	$("#btn-ctk-perhari").on('click', function (e) {
		e.preventDefault();
		$("#cetak_absensi").modal("show");
		$("#label_modal_absensi").html("Cetak Persensi Harian");
		$(".modal-body form").attr('action', url + 'Absensi/cetak_persensiHarian');
		$("#tgl_absen_cetak1").hide();
	});

	$("#cetak").on('click', function () {
		$("#cetak_absensi").modal("hide");
		// $('#tgl_absen_cetak').val("");
	});

	//cetak perbulan
	$("#btn-ctk-perbulan").on('click', function (e) {
		e.preventDefault();
		$("#cetak_absensi").modal("show");
		$("#label_modal_absensi").html("Cetak Persensi Bulanan");
		$("#tgl_absen_cetak1").show();
		$(".modal-body form").attr('action', url + 'Absensi/cetak_rekapPerpriode');
	});

	// list absensi_untuk user_op_sekretaris
	const table = $("#tbl_absensi_forUser").DataTable({
		"pageLength": 5,
		"serverSide": true,
		"order": [
			[0, "asc"]
		],
		'serverMethod': 'post',
		'searching': true,
		"ajax": {
			url: url + 'Operator/getAbsensiUser_id',
			// type: 'post'
			'data': function (data) {
				// Read values
				var from_date = $('#search_fromdate1').val();
				// var to_date = $('#search_todate').val();

				// Append to data
				data.searchByFromdate = from_date;
				// data.searchByTodate = to_date;
			}
		},
	});

	$('.waktu_absen').change(function () {
		table.draw();
	});
});





