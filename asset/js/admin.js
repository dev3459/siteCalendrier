/*******************************************************
 **  Initiate datatables in roles, tables, users page **
 *******************************************************/
$('.dataTables').DataTable({
    responsive: true,
    pageLength: 20,
    lengthChange: false,
    searching: true,
    ordering: true,
    columnDefs: [ {
        targets  : 'no-sort',
        orderable: false,
    }],
    language: {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }
});

/******************************************
 ** Toggle sidebar on Menu button click  **
 ******************************************/
$('#sidebarCollapse').on('click', function() {
    $('#sidebar').toggleClass('active');
    $('#body').toggleClass('active');
});

/*************************************************************** **
 **  Auto-hide sidebar on window resize if window size is small  **
 ******************************************************************/
$(window).on('resize', function () {
     if ($(window).width() <= 768) {
         $('#sidebar, #body').addClass('active');
     }
});


/******************************************
 **  Handling meetings details ************
 ******************************************/
$('.show-meeting-details').click(function() {
    const id = $(this).find('[data-name="id"]').text();
    const name = $(this).find('[data-name="location"]').text();
    const date = $(this).find('[data-name="date"]').text();
    const project = $(this).find('[data-name="project"]').text();
    const clientFirstName = $(this).find('[data-name="client-first-name"]').text();
    const clientLastName = $(this).find('[data-name="client-last-name"]').text();
    const clientMail = $(this).find('[data-name="client-mail"]').text();
    const clientPhone = $(this).find('[data-name="client-phone"]').text();
    const employeeFirstName = $(this).find('[data-name="employee-first-name"]').text();
    const employeeLastName = $(this).find('[data-name="employee-last-name"]').text();
    const employeeMail = $(this).find('[data-name="employee-mail"]').text();
    const employeePhone = $(this).find('[data-name="employee-phone"]').text();
    const employeeComment = $(this).find('[data-name="employee-comment"]').text();

    // Replace the meeting_id in link.
    const addComment = $('#add_comment');
    addComment.attr('href', addComment.attr('href').substring(0, addComment.attr('href').lastIndexOf('=') + 1) + id);

    $('#pill-informations').html(`
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>Lieu</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    <tr>
                        <td>${name}</td>
                        <td>${date}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <th>Client</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>${clientFirstName}</td>
                        <td>${clientLastName}</td>
                        <td><a href="mailto:${clientMail}">${clientMail}</a></td>
                        <td><a href="tel:${clientPhone}">${clientPhone}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>    
    `);


    $('#pill-employee').html(`
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>Employé</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>${employeeFirstName}</td>
                        <td>${employeeLastName}</td>
                        <td><a href="mailto:${employeeMail}">${employeeMail}</a></td>
                        <td><a href="tel:${employeePhone}">${employeePhone}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>    
    `);

    $('#pill-project').html(`
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>Projet</th>
                </thead>
                <tbody>
                    <tr>
                        <td>${project}</td>
                    </tr>
                </tbody>
            </table>
        </div>    
    `);

    $('#comment-content').html(`
        ${employeeComment.length > 0 ? employeeComment : 'Aucun commentaire, ajoutez en un si vous le souhaitez.'}
    `);

    $('#comment-button').html(`
        ${employeeComment.length > 0 ? 'Editer le commentaire' : 'Ajouter un commentaire'}
    `);

    $('#meeting-details').show();
});


/*************************************
 **  Handle click on tabs meetings  **
 *************************************/
const tabs = $('#pill-employee-tab, #pill-informations-tab, #pill-project-tab, #pill-employee-comment-tab');
tabs.click(function(){
    tabs.removeClass('active');
    $(this).addClass('active');
    $('#pill-project, #pill-informations, #pill-employee, #pill-employee-comment').removeClass('active').removeClass('show');
    $('#' + $(this).attr('id').replace('-tab', '')).addClass('active').addClass('show');
});