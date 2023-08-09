import { Divider, Grid, Paper, Stack, Typography } from "@mui/material";
import React from "react";
import Pairs from "./Pairs";
import LoadingTable from "./LoadingTable";

const Dashboard = function () {
  const [dataLoaded,setDataLoaded] = React.useState(false);
  const [currentData,setCurrentData] = React.useState([]);

  React.useEffect(() => {
    axios.get('pairs')
      .then(response => {
        setCurrentData(response.data.current);
        setDataLoaded(true);
      });
  },[]);

  if(!dataLoaded)
    return <LoadingTable columnsNum={2} component={Paper} />

  return <Grid container spacing={2}>
    <Grid item xs={12}>
      <Pairs title="today" emphasize pairs={currentData.pairs}/>
    </Grid>
    <Grid item xs={12}>
      <Stack direction="row" justifyContent="right"
        divider={<Divider orientation="vertical" flexItem />}
        spacing={2}>
        <Typography className="footerInfoCode">kwa</Typography>
        <Typography className="footerInfoCode">kwa</Typography>
        <Typography className="footerInfoCode">kwa</Typography>
      </Stack>
    </Grid>
  </Grid>
}

export default Dashboard;
