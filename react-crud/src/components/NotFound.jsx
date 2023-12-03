import "./NotFound.css";
import { Link } from "react-router-dom";

function NotFound() {
  return (
    <div className="section">
      <h1 className="error">404</h1>
      <div className="page">
        Ooops!!! The page you are looking for is not found
      </div>
      <Link to={"/"} className="back-home">
        Back to course
      </Link>
    </div>
  );
}

export default NotFound;
