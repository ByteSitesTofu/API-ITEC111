import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

function Itec_116() {
  const [users, setUsers] = useState({});

  useEffect(() => {
    getUser();
  }, []);

  function getUser() {
    axios
      .get("http://localhost:3000/api/lms")
      .then(function (response) {
        setUsers(response.data);
      })
      .catch(function (error) {
        console.error("Error fetching user: ", error);
      });
  }

  const deleteUser = (id) => {
    axios
      .delete(`http://localhost:3000/api/lms/${id}/delete`)
      .then(function (response) {
        console.log(response.data);
        getUser();
      });
  };

  return (
    <div className="list-user">
      <h3>Students</h3>

      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course code</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {Array.isArray(users) && users.length > 0 ? (
            users
              .filter((user) => user.course_code === "ITEC-116")
              .map((filteredUser, key) => (
                <tr key={key}>
                  <td>{key + 1}</td>
                  <td>{filteredUser.student_id}</td>
                  <td>{filteredUser.name}</td>
                  <td>{filteredUser.email}</td>
                  <td>{filteredUser.course_code}</td>
                  <td className="btn">
                    <button>
                      <Link to={`/course/${filteredUser.id}/update`}>
                        Update
                      </Link>
                    </button>
                    <button onClick={() => deleteUser(filteredUser.id)}>
                      Delete
                    </button>
                  </td>
                </tr>
              ))
          ) : (
            <tr>
              <td>No users found</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default Itec_116;
