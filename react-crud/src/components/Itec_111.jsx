import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { BsSearch } from "react-icons/bs";

function Itec_111() {
  const [users, setUsers] = useState({});
  const [search, setSearch] = useState("");

  useEffect(() => {
    getUser();
  }, []);

  function getUser() {
    axios
      .get("http://localhost/api/lms")
      .then(function (response) {
        setUsers(response.data);
      })
      .catch(function (error) {
        console.error("Error fetching user: ", error);
      });
  }

  const deleteUser = (id) => {
    axios
      .delete(`http://localhost/api/lms/${id}/delete`)
      .then(function (response) {
        console.log(response.data);
        getUser();
      });
  };

  return (
    <div className="list-user">
      <h3>Students</h3>

      <form>
        <div>
          <input
            type="text"
            placeholder="Search students"
            onChange={(e) => setSearch(e.target.value)}
          />
          <BsSearch className="search-icon" />
        </div>
      </form>

      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course code</th>
            {/* <th>Actions</th> */}
          </tr>
        </thead>
        <tbody>
          {Array.isArray(users) && users.length > 0 ? (
            users
              .filter(
                (user) =>
                  user.course_code === "ITEC-111" &&
                  user.is_deleted != "1" &&
                  (search.toLowerCase() === "" ||
                    user.student_id
                      .toLowerCase()
                      .includes(search.toLowerCase()) ||
                    user.name.toLowerCase().includes(search.toLowerCase()))
              )
              .map((filteredUser, key) => (
                <tr key={key}>
                  <td>{key + 1}</td>
                  <td>{filteredUser.student_id}</td>
                  <td>
                    {filteredUser.fname} {filteredUser.lname}
                  </td>
                  <td>{filteredUser.email}</td>
                  <td>{filteredUser.course_code}</td>
                  {/* Reserved function */}
                  {/* <td className="btn">
                    <button>
                      <Link to={`/course/${filteredUser.id}/update`}>
                        Update
                      </Link>
                    </button>
                    <button onClick={() => deleteUser(filteredUser.id)}>
                      Delete
                    </button>
                  </td> */}
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

export default Itec_111;
