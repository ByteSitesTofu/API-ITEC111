import React from "react";
import "./App.scss";
import Itec_111 from "./components/Itec_111";
import Itec_116 from "./components/Itec_116";
import Test from "./components/Test";
// import CreateUser from "./components/CreateUser";
// import UpdateUser from "./components/UpdateUser";
import Navbar from "./components/Navbar";
import NotFound from "./components/NotFound";
import Courses from "./components/Courses";
import { BrowserRouter, Route, Routes, Switch } from "react-router-dom";
import TestDetail from "./components/TestDetails";

function App() {
  return (
    <>
      <BrowserRouter>
        <Navbar />
        <Routes>
          <Route index element={<Courses />} />
          <Route path="course/Itec-111/" element={<Itec_111 />} />
          <Route path="course/Itec-116/" element={<Itec_116 />} />
          <Route path="/test" element={<Test />} />
          <div>
            <Switch>
              <Route path="/subjects/:subjectId" component={<TestDetail />} />
              <Route path="/subjects" component={<Test />} />
            </Switch>
          </div>
          {/* <Route path="course/add_student/" element={<CreateUser />} />
          <Route path="course/:id/update" element={<UpdateUser />} /> */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </>
  );
}

export default App;
