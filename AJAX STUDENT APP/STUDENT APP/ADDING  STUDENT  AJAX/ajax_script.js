function loadStudents() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById('studentInfo').innerHTML = xhr.responseText;
      } else {
        console.error('Failed to load students.');
      }
    }
  };
  xhr.open('GET', 'api.php', true);
  xhr.send();
}

function addStudent() {
  var name = document.getElementById('stuname').value;
  var age = document.getElementById('age').value;
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var grade = document.getElementById('grade').value;
  var prof = document.getElementById('prof').files[0];

  var formData = new FormData();
  formData.append('name', name);
  formData.append('age', age);
  formData.append('email', email);
  formData.append('password', password);
  formData.append('grade', grade);
  formData.append('prof', prof);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        loadStudents();
      } else {
        console.error('Failed to add student.');
      }
    }
  };
  xhr.open('POST', 'api.php', true);
  xhr.send(formData);
}

function editStudent(id) {
  var student = {
    id: id,
    name: prompt('Enter the student name:'),
    age: prompt('Enter the student age:'),
    grade: prompt('Enter the student grade:'),
  };

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        loadStudents();
      } else {
        console.error('Failed to update student.');
      }
    }
  };
  xhr.open('PUT', 'api.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify(student));
}

function deleteStudent(id) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        loadStudents();
      } else {
        console.error('Deleting Student Failed');
      }
    }
  };
  xhr.open('DELETE', 'api.php?id=' + id, true);
  xhr.send();
}

loadStudents(); // Initial load of students when the page loads
