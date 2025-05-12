const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

/*graph*/



const ctx = document.getElementById('myChart');
const myChart2 = document.getElementById('myChart2');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Hot Coffee', 'Iced Coffee', 'Bread', 'Pasta', 'Burger'],
      datasets: [{
        label: 'Products',
        data: [12, 19, 3, 5, 23, 3],
      }]
    },
    options: {
      responsive: true,
    }
  });

  new Chart(myChart2, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug','Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Earnings',
        data: [12, 19, 3, 5, 2, 3,12, 19, 3, 5, 2, 3],
      }]
    },
    options: {
      responsive: true,
    }
  });  

  

  

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

