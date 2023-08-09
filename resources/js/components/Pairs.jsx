import { Paper, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from "@mui/material";
import { green } from "@mui/material/colors";
import SwapHorizIcon from '@mui/icons-material/SwapHoriz';
import React from "react";

const cellWidth = "150px";
const smallCellWidth = "50px";

const NormalTableCell = function (props) {
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block"
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const EmphasizedTableCell = function(props){
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      color: green[200],
      textTransform: "title",
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block"
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const TableRows = function({rows, emphasize}){
  const CellComponent = emphasize ? EmphasizedTableCell : NormalTableCell;

  if(rows.length === 0)
    return <TableRow>
      <CellComponent align="center">table empty</CellComponent>
    </TableRow>

  const renderRows = rows.map((row, rowIndex) =>
    <TableRow key={rowIndex}>
      <CellComponent align="right">{row[0]}</CellComponent>
      <CellComponent align="center" small={1} style={{
        width: smallCellWidth
      }}><SwapHorizIcon /></CellComponent>
      <CellComponent>{row[1]}</CellComponent>
    </TableRow>
  )

  return renderRows;
}

const Pairs = function({title, pairs = [], emphasize = false}){
  return <React.Fragment>
    <Typography variant="h2" sx={{
      color: emphasize ? green[500] : null,
      textTransform: "uppercase"
    }}>{title}</Typography>
    <TableContainer component={Paper} elevation={1}>
      <Table>
        <TableBody>
          <TableRows rows={pairs} emphasize={emphasize} />
        </TableBody>
      </Table>
    </TableContainer>
  </React.Fragment>
}

export default Pairs;
