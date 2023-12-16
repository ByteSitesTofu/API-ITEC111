import { Link } from "react-router-dom";

function Courses() {
  return (
    <main>
      <ul>
        <li>
          <Link to={"course/Itec-111/"}>ITEC 111</Link>
        </li>
        <li>
          <Link to={"course/Itec-116/"}>ITEC 116</Link>
        </li>
      </ul>
    </main>
  );
}

export default Courses;
