import { Link } from "react-router-dom";
import { BsCardList, BsSearch, BsFillPlusSquareFill } from "react-icons/bs";

function Navbar() {
  return (
    <nav>
      <h2>Wonder Sulit LMS</h2>
      <ul>
        {/* <li>
          <Link to={"/course/add_student"}>
            <BsFillPlusSquareFill className="add-icon" />
            Add Student
          </Link>
        </li> */}

        <li>
          <Link to={"/"}>
            <BsCardList />
            Course
          </Link>
        </li>
        <li>
          <Link to={"/test"}>Test</Link>
        </li>
      </ul>
    </nav>
  );
}

export default Navbar;
