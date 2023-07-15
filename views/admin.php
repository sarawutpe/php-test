<?php require_once "admin_header.php" ?>
<!-- Main Content -->
<div id="content">

	<!-- Topbar -->
	<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

		<!-- Sidebar Toggle (Topbar) -->
		<button  id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
			<i class="fa fa-bars"></i>
		</button>

		<!-- Topbar Search -->
		<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
			<div class="input-group">
				<input id="search" oninput="handleSearch()" type="text" class="form-control bg-light border-0 small" placeholder="Search Name" aria-label="Search" aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-primary" type="button" onclick="handleSearch()">
						<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
		</form>

		<!-- Topbar Navbar -->
		<ul class="navbar-nav ml-auto">

			<!-- Nav Item - Search Dropdown (Visible Only XS) -->
			<li class="nav-item dropdown no-arrow d-sm-none">
				<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-search fa-fw"></i>
				</a>
				<!-- Dropdown - Messages -->
				<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
					<form class="form-inline mr-auto w-100 navbar-search">
						<div class="input-group">
							<input type="text" value="" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
							<div class="input-group-append">
								<button class="btn btn-primary" type="button">
									<i class="fas fa-search fa-sm"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</li>

			<!-- Nav Item - Alerts -->
			<li class="nav-item dropdown no-arrow mx-1">
				<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-bell fa-fw"></i>
					<!-- Counter - Alerts -->
					<span class="badge badge-danger badge-counter">3+</span>
				</a>
			</li>

			<!-- Nav Item - Messages -->
			<li class="nav-item dropdown no-arrow mx-1">
				<a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-envelope fa-fw"></i>
					<!-- Counter - Messages -->
					<span class="badge badge-danger badge-counter">7</span>
				</a>
			</li>

			<div class="topbar-divider d-none d-sm-block"></div>

			<!-- Nav Item - User Information -->
			<li class="nav-item dropdown no-arrow">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="mr-2 d-none d-lg-inline text-gray-600 small">MR</span>
					<img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
				</a>
			</li>

		</ul>

	</nav>
	<!-- End of Topbar -->

	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
			<button onclick="handleOpenFormModal(null)" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
				<i class="fa-solid fa-plus text-white-50"></i>
				Add Employee
			</button>
		</div>


		<div class="card-table card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Employees</h6>
			</div>

			<!-- Loading -->
			<div id="loading" class="linear-progress-content">
				<div class="linear-progress"></div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Salary</th>
								<th>Date Employed</th>
								<th>Position</th>
								<th>Status</th>
								<th>Create Time</th>
							</tr>
						</thead>
						<tbody id="data-table"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php require_once "admin_footer.php" ?>

<script>
	function showAlert(icon, message) {
		Swal.fire({
			position: 'top-end',
			icon: icon,
			title: message || 'Your work has been saved',
			showConfirmButton: false,
			timer: 3000,
		})
	}

	function showConfirm(message) {
		return new Promise((resolve, reject) => {
			Swal.fire({
				title: message,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Confirm'
			}).then((result) => {
				if (result.isConfirmed) {
					resolve(true);
				} else {
					reject(false);
				}
			});
		});
	}

	function showLoading() {
		$('#loading').addClass("active")
	}

	function hideLoading() {
		setTimeout(() => {
			$('#loading').removeClass("active")
		}, 1000);
	}


	function getEmployeeList() {
		showLoading()

		const q = $("input#search").val() || ""
		const url = `${window.location.origin}/api/employee/list?q=${q}`;

		$.ajax({
			url: url,
			type: 'GET',
			success: function(response) {
				if (!response.success) {
					showAlert("error", response?.message ?? "");
					return;
				}

				const data = response.data;
				const tableElement = $('#data-table').empty();
				let rowElement = "";

				data.forEach(function(employee) {
					rowElement += `
						<tr>
							<td>
								<div class="d-flex justify-content-center">
									<button onclick="handleOpenFormModal('${JSON.stringify(employee).replace(/"/g, '&quot;')}')" class="mr-2 btn btn-success btn-icon-split btn-sm">
										<span class="icon text-white-50">
											<i class="fa-solid fa-file-pen"></i>
										</span>
										<span class="text"></span>
									</button>
									<button onclick="handleDeleteEmployee(${employee.id})" class="ml-2 btn btn-danger btn-icon-split btn-sm">
										<span class="icon text-white-50">
											<i class="fa-solid fa-trash"></i>
										</span>
										<span class="text"></span>
									</button>
								</div>
							</td>
							<td>${employee.name}</td>
							<td>${employee.salary}</td>
							<td>${employee.dateEmployed}</td>
							<td>${employee.position}</td>
							<td><div class="ml-3 rounded-circle ${employee.status == 1 ? 'bg-success' : 'bg-danger'}" style="width: 10px; height: 10px"></div></td>
							<td>${employee.timestamp}</td>
						</tr>
      		`;
				});

				tableElement.append(rowElement);
			},
			error: function(xhr, status, error) {

				console.log(error)
				// Request failed
				showAlert("error", error);
				hideLoading()
			},
			complete: function() {
				hideLoading()
			}
		});
	}

	function handleOpenFormModal(jsonData) {
		const data = JSON.parse(jsonData) || ""

		Swal.fire({
			title: data ? 'Edit Employee' : 'Add Employee',
			html: `
				<form class="p-2">
					<input id="id" type="hidden" class="form-control" placeholder="Name" value="${data.id || ""}">
					<div class="form-group">
						<label class="w-100 text-left" style="font-size: 14px">Name*</label>
						<input id="name" type="text" class="form-control" placeholder="Name" value="${data.name || ""}">
					</div>
					<div class="form-group">
						<label class="w-100 text-left" style="font-size: 14px">Salary*</label>
						<input id="salary" type="number" class="form-control" placeholder="Salary" value="${data.salary || ""}">
					</div>
					<div class="form-group">
						<label class="w-100 text-left" style="font-size: 14px">Date Employed</label>
						<input id="date-employed" type="datetime-local" value="${data.dateEmployed || dayjs().format('YYYY-MM-DDTHH:mm')}" class="form-control">
					</div>
					<div class="form-group">
						<label class="w-100 text-left" style="font-size: 14px">Position*</label>
						<input id="position" type="text" class="form-control" placeholder="Position" value="${data.position || ""}">
					</div>
					<div class="form-group">
						<label class="w-100 text-left" style="font-size: 14px">Status</label>
						<div class="d-flex">
							<div class="mr-4">
								<input style="height: auto" id="work" type="radio" name="status" value="1" checked>
								<label style="font-size: 14px" for="work">Work</label>
							</div>
							<div class="mr-4">
							<input style="height: auto" id="leave" type="radio" name="status" value="0" ${data?.status == 0 ? 'checked' : ''}>
								<label style="font-size: 14px" for="leave">Leave</label>
							</div>
						</div>
					</div>
				</form>
			`,
			showCancelButton: true,
			preConfirm: () => {
				return new Promise((resolve) => {
					const id = $('input#id').val();
					const name = $('input#name').val();
					const salary = $('input#salary').val();
					const dateEmployed = $('input#date-employed').val();
					const position = $('input#position').val();
					const status = $("input[name='status']:checked").val()

					if (!name || !salary || !position) {
						Swal.showValidationMessage('Please fill in all required fields');
						resolve(false);
					} else {
						resolve({
							id: id,
							name: name,
							salary: salary,
							dateEmployed: dateEmployed,
							position: position,
							status: status
						});
					}
				});
			}
		}).then((result) => {
			if (result.isConfirmed && result.value.id) {
				handleUpdateEmployee(result.value)
			}

			if (result.isConfirmed && !result.value.id) {
				handleCreateEmployee(result.value)
			}
		})
	}

	function handleCreateEmployee(data) {
		const url = `${window.location.origin}/api/employee`;
		$.ajax({
			url: url,
			type: 'POST',
			contentType: 'application/json',
			data: JSON.stringify(data),
			success: function(response) {
				if (!response.success) {
					showAlert("error", response?.message ?? "");
					return;
				}

				getEmployeeList();
			},
			error: function(xhr, status, error) {
				showAlert("error", error);
			}
		});
	}

	function handleUpdateEmployee(data) {
		const url = `${window.location.origin}/api/employee/${data.id}`;
		$.ajax({
			url: url,
			type: 'PUT',
			contentType: 'application/json',
			data: JSON.stringify(data),
			success: function(response) {
				if (!response.success) {
					showAlert("error", response?.message ?? "");
					return;
				}

				getEmployeeList();
			},
			error: function(xhr, status, error) {
				showAlert("error", error);
			}
		});
	}

	async function handleDeleteEmployee(id) {
		const isConfirm = await showConfirm(`Are you sure to delete ${id}?`)
		if (isConfirm) {
			const url = `${window.location.origin}/api/employee/${id}`;
			$.ajax({
				url: url,
				type: 'DELETE',
				success: function(response) {
					if (!response.success) {
						showAlert("error", response?.message ?? "");
						return;
					}

					getEmployeeList();
				},
				error: function(xhr, status, error) {
					showAlert("error", error);
				}
			});
		}
	}

	let timeout;

	function handleSearch() {
		clearTimeout(timeout);

		timeout = setTimeout(() => {
			getEmployeeList();
		}, 400);
	}

	$(document).ready(function() {
		getEmployeeList()
	})
</script>

</body>

</html>