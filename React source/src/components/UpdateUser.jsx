import { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";

function UpdateUser() {
  const Navigate = useNavigate();

  const [inputs, setInputs] = useState({});

  const { id } = useParams();

  useEffect(() => {
    getUsers();
  }, []);

  function getUsers() {
    axios
      .get(`http://localhost:3000/api/lms/${id}`)
      .then(function (response) {
        const responseData = response.data;
        if (responseData && typeof responseData === "object") {
          setInputs(responseData);
        } else {
          console.error("Invalid user data format.", responseData);
        }
      })
      .catch(function (error) {
        console.error("Error fetching user: ", error);
      });
  }

  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;

    setInputs((values) => ({ ...values, [name]: value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    axios
      .put(`http://localhost:3000/api/lms/${id}/update`, inputs)
      .then(function (response) {
        console.log(response.data);
        Navigate("/course/students");
      });
  };

  return (
    <div className="update-user">
      <h3>Update User</h3>
      <form onSubmit={handleSubmit}>
        <label>Student ID:</label>
        <input
          placeholder="1234-00123"
          value={inputs.student_id}
          maxLength={11}
          type="text"
          name="student_id"
          onChange={handleChange}
        />
        <label>Name:</label>
        <input
          value={inputs.name}
          type="text"
          name="name"
          onChange={handleChange}
        />
        <label>Email:</label>
        <input
          value={inputs.email}
          type="email"
          name="email"
          onChange={handleChange}
        />
        <label>Course:</label>
        <input
          placeholder="course-111"
          value={inputs.course_code}
          type="text"
          maxLength={11}
          name="course_code"
          onChange={handleChange}
        />
        <button>Save</button>
      </form>
    </div>
  );
}

export default UpdateUser;
