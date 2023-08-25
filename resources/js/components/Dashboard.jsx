import { Divider, Grid, Paper, Stack, Typography } from "@mui/material";
import React from "react";
import Pairs from "./Pairs";
import LoadingTable from "./LoadingTable";
import Moment from "./Moment";
import { grey } from "@mui/material/colors";
import GithubRepositoryChip from "./GithubRepositoryChip";

const Dashboard = function () {
  const [dataLoaded,setDataLoaded] = React.useState(false);
  const [currentData,setCurrentData] = React.useState([]);

  React.useEffect(() => {
    axios.get('/pairs')
      .then(response => {
        setCurrentData(response.data);
        setDataLoaded(true);
      });
  },[]);

  if(!dataLoaded)
    return <LoadingTable columnsNum={2} component={Paper} />

  return <Grid container spacing={2}>
    <Grid item xs={3} />
    <Grid item xs={6}
      display="grid"
      justifyItems= "center"
    >
      <Typography className="footerInfoCode">{currentData.message}</Typography>
    </Grid>
    <Grid item xs={3} />

    <Grid item xs={12}
      display="grid"
      justifyItems= "center"
    >
      <Pairs width="70%" title="today" emphasize pairs={currentData.current.pairs}/>
    </Grid>
    <Grid item xs={12}>
      <Stack direction="row"
        divider={<Divider orientation="vertical" flexItem />}
        justifyContent="center"
        alignItems="center"
        spacing={2}>
        <Typography className="footerInfoCode">Season {currentData.current.season}</Typography>
        <Typography className="footerInfoCode">Set {currentData.current.rotations}</Typography>
        <Typography className="footerInfoCode"><Moment format="h:mma dddd, MMMM DD, YYYY">{currentData.current.generated}</Moment></Typography>
        <GithubRepositoryChip />
      </Stack>
    </Grid>

    <Grid item xs={12}
      display="grid"
      justifyItems="center">
      <Divider width="70%"
        sx={{
          bgcolor: grey[900]
          , borderBottomWidth: 3
         }} />
    </Grid>

    <Grid item xs={2} />
    <Grid item xs={4}>
      <Pairs title="previous" pairs={currentData.yesterday} />
    </Grid>
    <Grid item xs={4}>
      <Pairs title="next" pairs={currentData.tomorrow} />
    </Grid>
    <Grid item xs={2} />
  </Grid>
}

export default Dashboard;
