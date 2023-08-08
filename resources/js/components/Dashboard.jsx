import { Stack } from "@mui/material";
import React from "react";
import Pairs from "./Pairs";

const Dashboard = function () {
  const [currentPairs,setCurrentPairs] = React.useState([]);

  React.useEffect(() => {
    axios.get('pairs')
      .then(response => {
        setCurrentPairs(response.data.current.pairs)
      });
  },[]);

  return <Stack>
    <Pairs title="today" emphasize pairs={currentPairs}/>
  </Stack>
}

export default Dashboard;
