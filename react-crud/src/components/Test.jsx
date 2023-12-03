import { Link } from "react-router-dom";

const subjects = [
  { id: 1, title: "Mathematics" },
  { id: 2, title: "History" },
  // Add more subjects as needed
];

function Courses() {
  return (
    <div>
      <h2>Subjects</h2>
      <ul>
        {subjects.map((subject) => (
          <li key={subject.id}>
            <Link to={`/subjects/${subject.id}`}>{subject.title}</Link>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default Courses;
