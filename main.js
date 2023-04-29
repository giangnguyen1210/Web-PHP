try {

}
catch(e) {}



///////////////////////////////
////////// login.php //////////
///////////////////////////////
try {
	let loginForm = document.getElementById("login-form");
	let loginUsername = document.getElementById("login-username");
	let loginPassword = document.getElementById("login-password");
	let loginErr = document.getElementById("login-err");

	loginForm.addEventListener("submit", (e) => {
		if ( !loginUsername.value ) {
			e.preventDefault();
			loginErr.textContent = "Chưa nhập tài tài khoản";
			loginErr.classList.remove("fade");
		} 
		else if ( !loginPassword.value ) {
			e.preventDefault();
			loginErr.textContent = "Chưa nhập mật khẩu";
			loginErr.classList.remove("fade");
		}
		else if (loginPassword.value.length < 6) {
			e.preventDefault();
			loginErr.textContent = "Mật khẩu ít nhất 6 kí tự";
			loginErr.classList.remove("fade");
		}
	});
}
catch (e) {}



//////////////////////////////////////
////////// new-password.php //////////
//////////////////////////////////////
try {
	let newPasswordForm = document.getElementById("newPassword-form");
	let newPasswordPassword = document.getElementById("newPassword-password");
	let newPasswordRePassword = document.getElementById("newPassword-rePassword");
	let newPasswordErr = document.getElementById("newPassword-err");

	newPasswordForm.addEventListener("submit", (e) => {
		if ( !newPasswordPassword.value ) {
			e.preventDefault();
			newPasswordErr.textContent = "Chưa nhập mật khẩu mới";
		} 
		else if ( newPasswordPassword.value.length < 6 ) {
			e.preventDefault();
			newPasswordErr.textContent = "Mật khẩu mới ít nhất phải có 6 kí tự";
		}
		else if ( !newPasswordRePassword.value ) {
			e.preventDefault();
			newPasswordErr.textContent = "Chưa nhập lại mật khẩu mới";
		}
		else if (newPasswordPassword.value !== newPasswordRePassword.value) {
			e.preventDefault();
			newPasswordErr.textContent = "Nhập lại mật khẩu mới không trùng khớp";
		}
	});
}
catch (e) {}



/////////////////////////////////////////
////////// change-password.php //////////
/////////////////////////////////////////
try {
	let changePasswordForm = document.getElementById("changePassword-form");
	let changePasswordOldPassword = document.getElementById("changePassword-oldPassword");
	let changePasswordPassword = document.getElementById("changePassword-password");
	let changePasswordRePassword = document.getElementById("changePassword-rePassword");
	let changePasswordErr = document.getElementById("changePassword-err");

	changePasswordForm.addEventListener("submit", (e) => {
		if ( !changePasswordOldPassword.value ) {
			e.preventDefault();
			changePasswordErr.textContent = "Chưa nhập mật khẩu cũ";
		} 
		else if ( changePasswordOldPassword.value.length < 6 ) {
			e.preventDefault();
			changePasswordErr.textContent = "Mật khẩu cũ ít nhất phải có 6 kí tự";
		}
		if ( !changePasswordPassword.value ) {
			e.preventDefault();
			changePasswordErr.textContent = "Chưa nhập mật khẩu mới";
		} 
		else if ( changePasswordPassword.value.length < 6 ) {
			e.preventDefault();
			changePasswordErr.textContent = "Mật khẩu mới ít nhất phải có 6 kí tự";
		}
		else if ( !changePasswordRePassword.value ) {
			e.preventDefault();
			changePasswordErr.textContent = "Chưa nhập lại mật khẩu mới";
		}
		else if (changePasswordRePassword.value !== changePasswordPassword.value) {
			e.preventDefault();
			changePasswordErr.textContent = "Nhập lại mật khẩu mới không trùng khớp";
		}
	});
}
catch (e) {}



//////////////////////////////////
////////// nghiphep.php //////////
//////////////////////////////////
try {
	let nghiPhepForm = document.getElementById("nghiPhep-form");
	let nghiPhepReason = document.getElementById("reason");
	let nghiPhepStartDay = document.getElementById("start_day");
	let nghiPhepEndDay = document.getElementById("end_day");
	let nghiPhepErr = document.getElementById("nghiPhep-err");

	nghiPhepForm.addEventListener("submit", (e) => {
		if ( !nghiPhepReason.value ) {
			e.preventDefault();
			nghiPhepErr.textContent = "Chưa nhập lí do";
		} 
		else if ( !nghiPhepStartDay.value ) {
			e.preventDefault();
			nghiPhepErr.textContent = "Chưa chọn ngày bắt đầu";
		}
		else if ( !nghiPhepEndDay.value ) {
			e.preventDefault();
			nghiPhepErr.textContent = "Chưa chọn ngày kết thúc";
		}
	});
}
catch (e) {}



///////////////////////////////////////////
////////// update_department.php //////////
///////////////////////////////////////////
try {
	let updateDepartmentForm = document.getElementById("updateDepartment-form");
	let nghiPhepReason = document.getElementById("reason");
	let nghiPhepStartDay = document.getElementById("start_day");
	let nghiPhepEndDay = document.getElementById("end_day");
	let updateDepartmentErr = document.getElementById("nghiPhep-err");

	updateDepartmentForm.addEventListener("submit", (e) => {
		if ( !nghiPhepReason.value ) {
			e.preventDefault();
			updateDepartmentErr.textContent = "Chưa nhập lí do";
		} 
		else if ( !nghiPhepStartDay.value ) {
			e.preventDefault();
			updateDepartmentErr.textContent = "Chưa nhập nhọn ngày";
		}
		if ( !nghiPhepEndDay.value ) {
			e.preventDefault();
			updateDepartmentErr.textContent = "Chưa nhập nhọn ngày";
		}
	});
}
catch (e) {}




//////////////////////////////////
////////// new-task.php //////////
//////////////////////////////////
try {
	let newTaskForm = document.getElementById("newTask-form");
	let newTaskTitle = document.getElementById("newTask-title");
	let newTaskDescription = document.getElementById("newTask-description");
	let newTaskTime = document.getElementById("newTask-time");

	newTaskForm.addEventListener("submit", (e) => {
		if ( !newTaskTitle.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa nhập tiêu đề";
		} 
		else if ( !newTaskDescription.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa nhập mô tả";
		}
		if ( !newTaskTime.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa chọn hạn";
		} 
	});
}
catch (e) {}

////////////////////////////////////////
////////// nv-task-detail.php //////////
////////////////////////////////////////
try {
	let newTaskForm = document.getElementById("newTask-form");
	let newTaskTitle = document.getElementById("newTask-title");
	let newTaskDescription = document.getElementById("newTask-description");
	let newTaskTime = document.getElementById("newTask-time");

	newTaskForm.addEventListener("submit", (e) => {
		if ( !newTaskTitle.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa nhập tiêu đề";
		} 
		else if ( !newTaskDescription.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa nhập mô tả";
		}
		if ( !newTaskTime.value ) {
			e.preventDefault();
			newTaskErr.textContent = "Chưa chọn hạn";
		} 
	});
}
catch (e) {}



//////////////////////////////////
////////// new-user.php //////////
//////////////////////////////////
try {
	let newUserForm = document.getElementById("newUser-form");
	let newUserUsername = document.getElementById("newUser-username");
	let newUserId = document.getElementById("newUser-id");
	let newUserName = document.getElementById("newUser-name");
	let newUserDate = document.getElementById("newUser-date");
	let newUserPhone = document.getElementById("newUser-phone");
	let newUserEmail = document.getElementById("newUser-email");
	let newUserSalary = document.getElementById("newUser-salary");
	let newUserErr = document.getElementById("newUser-err");

	newUserForm.addEventListener("submit", (e) => {
		if ( !newUserUsername.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập tài khoản";
		} 
		else if ( !newUserId.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập ID";
		}
		if ( !newUserName.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập Họ và tên";
		} 
		else if ( !newUserDate.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập năm sinh";
		}
		else if ( !newUserPhone.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập số điện thoại";
		}
		else if ( !newUserEmail.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập email";
		}
		else if ( !newUserSalary.value ) {
			e.preventDefault();
			newUserErr.textContent = "Chưa nhập Lương";
		}
	});
}
catch (e) {}



//////////////////////////////
////////// card.php //////////
//////////////////////////////
try {
	function theSwitch(the) {
		if (the.style.transform) {
			the.style.transform = "";
			the.style.boxShadow = "5px 5px 5px";
		}
		else {
			the.style.transform = "rotateY(180deg)";
			the.style.boxShadow = "-5px 5px 5px";
		}

		setTimeout(() => {
			the.children[0].classList.toggle("none");
			the.children[1].classList.toggle("none");
		}, 125);
	}
}
catch (e) {}

try {
	// var ele = document.getElementById("avatar");
	// ele.src = ele.dataset.src;
		// ví dụ sử dụng jquery
		// $(document).ready(() => {
		// 	// var d=$(".avatar").attr("src",$(this).find("avatar").data("src"));
		// 	console.log($(".avatar"));
		// 	//  $(".avatar").attr("src","second.jpg");
		// });

	var imgEl = document.querySelectorAll('img.avatar');

	for (var i = 0; i < imgEl.length; i++) {
				imgEl[i].setAttribute('src', imgEl[i].getAttribute('data-src'));
	}
}
catch (e) {}



//////////////////////////////////
////////// .........php //////////
//////////////////////////////////
try {
	const changeImg = document.getElementById("change-img");
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName ) {
				label.querySelector( 'span' ).innerHTML = fileName;
				changeImg.classList.remove("none");
			}
			else {
				label.innerHTML = labelVal;
				changeImg.classList.add("none");
			}
		});
	});
}
catch(e) {}



//////////////////////////////////
////////// .........php //////////
//////////////////////////////////
try {
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});
}
catch(e) {}



////////////////////////////////////////
////////// chi-tiet-phong.php //////////
////////////////////////////////////////
try {
	let id = null;

	$('#baiNhiem').on('show.bs.modal', function (event) {
		let button = $(event.relatedTarget);
		let recipient = button.data('whatever');
		id = button.data('id');
		let modal = $(this);
		modal.find('.modal-title').text('Bãi nhiệm ' + recipient);
	})
	$('#boNhiem').on('show.bs.modal', function (event) {
		let button = $(event.relatedTarget);
		let recipient = button.data('whatever');
		id = button.data('id'); 
		let modal = $(this);
		modal.find('.modal-title').text('Bổ nhiệm ' + recipient + ' lên trưởng phòng');
	})

	function bonhiem() {
		window.location = "/giam-doc/bonhiem.php?id=" + id;
	}

	function bainhiem() {
		window.location = "/giam-doc/bainhiem.php?id=" + id;
	}
}
catch(e) {}



///////////////////////////////////
////////// nhan-vien.php //////////
///////////////////////////////////
try {
	$('#rsPass').on('show.bs.modal', function (event) {
		let a = $(event.relatedTarget);
		console.log(event.relatedTarget);
		let recipient = a.data('whatever');
		let modal = $(this);
		modal.find('.modal-title').text('Đặt lại mật khẩu ' + recipient);
		let rs = document.getElementById("rs");
		rs.onclick = (e) => {window.location.href = "/reset_password.php?name=" + a.data('id')};
	})
}
catch(e) {}