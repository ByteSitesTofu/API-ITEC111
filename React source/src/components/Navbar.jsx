import { Link } from "react-router-dom";
import { BsCardList, BsFillPlusSquareFill } from "react-icons/bs";

function Navbar() {
  return (
    <nav>
      <h2>Wonder Sulit LMS</h2>
      <ul>
        <li>
          <Link to={"/course/add_student"}>
            <BsFillPlusSquareFill className="add-icon" />
            Add Student
          </Link>
        </li>
        <li>
          <Link to={"/"}>
            <BsCardList className="course-icon" />
            Course
          </Link>
        </li>
      </ul>
    </nav>
  );
}

export default Navbar;
