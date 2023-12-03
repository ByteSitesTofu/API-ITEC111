import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

function Course() {
  const Navigate = useNavigate();

  const [inputs, setInput] = useState({});

  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;

    setInput((values) => ({ ...values, [name]: value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    axios
      .post("http://localhost:3000/api/lms/save", inputs)
      .then(function (response) {
        console.log(response.data);
        Navigate("/");
      })
      .catch(function (error) {
        console.error("Error adding student: ", error);
      });
  };

  return (
    <div className="add-user">
      <h3>Add User</h3>
      <form onSubmit={handleSubmit}>
        <label>Name:</label>
        <input type="text" name="name" onChange={handleChange} />
        <label>Email:</label>
        <input type="text" name="email" onChange={handleChange} />
        <label>Student number:</label>
        <input
          placeholder="1234-00123"
          maxLength={10}
          type="text"
          name="student_id"
          onChange={handleChange}
        />
        <label>Course code:</label>
        <select name="course_code" onChange={handleChange}>
          <option value="">--Please select your course code--</option>
          <option value="ITEC-111">ITEC - 111</option>
          <option value="ITEC-116">ITEC - 116</option>
        </select>
        <button>Add</button>
      </form>
    </div>
  );
}

export default Course;
