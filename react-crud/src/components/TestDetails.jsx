// SubjectDetail.js
import React from "react";
import { useParams } from "react-router-dom";

const TestDetail = () => {
  const { subjectId } = useParams();

  // Fetch additional details about the subject based on subjectId

  return (
    <div>
      <h2>Subject Details</h2>
      <p>Subject ID: {subjectId}</p>
      {/* Display additional subject details here */}
    </div>
  );
};

export default TestDetail;
