import { Avatar, Paper, Stack, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from "@mui/material";
import { green, grey } from "@mui/material/colors";
import SwapHorizIcon from '@mui/icons-material/SwapHoriz';
import React from "react";

const cellWidth = "150px";
const smallCellWidth = "25px";

const smallAvatarSize = 24;
const normalAvatarSize = 32;

const CellText = function({emphasize = true, position = "left", ...props}) {
  if (typeof props.children === 'string') {
    const avatarSize = emphasize ? normalAvatarSize : smallAvatarSize;

    const textArray = props.children
      .split(',')
      .map((item) => item.trim());

    const avatarProps = {
      variant: "rounded"
      ,style: {
        backgroundColor: emphasize ? green[200] : grey[500]
      }
      ,sx: {
        width: avatarSize
        , height: avatarSize
      }
      , alt: textArray[1]
      , src: "/broken.jpg"
    };

    if(textArray.length > 1){
      const content = position === "left" ?
        <React.Fragment>
          <span>{textArray[0]}</span>
          <Avatar {...avatarProps} />
        </React.Fragment>
      :
        <React.Fragment>
          <Avatar {...avatarProps} />
          <span>{textArray[0]}</span>
        </React.Fragment>

      return <Stack direction="row"
        spacing={emphasize ? 1 : .5}
        alignItems="center"
        justifyContent={position === "left" ? "right" : "left"}>
        {content}
      </Stack>
    }else{
      return textArray[0];
    }
  } else {
    return props.children;
  }
}

const NormalTableCell = function ({emphasize, ...props}) {
  return <TableCell {...props}
    style={{
      ...props.style,
      borderBottom: 'none'
    }}>
    <Typography variant="p" sx={{
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block",
      color: grey[500]
    }}>
      <CellText position={props.position} emphasize={emphasize}>{props.children}</CellText>
    </Typography>
  </TableCell>
}

const EmphasizedTableCell = function({emphasize, ...props}){
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      color: green[200],
      textTransform: "capitalize",
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block"
    }}>
      <CellText position={props.position} emphasize={emphasize}>{props.children}</CellText>
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
      <CellComponent align="right" emphasize={emphasize}>{row[0]}</CellComponent>
      <CellComponent align="center" small={1} style={{
        width: smallCellWidth,
        padding: "0px"
      }}><SwapHorizIcon /></CellComponent>
      <CellComponent emphasize={emphasize} position="right">{row[1]}</CellComponent>
    </TableRow>
  )

  return renderRows;
}

const Pairs = function({title, pairs = [], emphasize = false}){
  const tableContainerProps = emphasize ?
    {
      component: Paper,
      elevation: 1
    } :
    {}

  const tableProps = emphasize ?
    {} :
    {
      size: "small"
    }

  return <React.Fragment>
    <Typography variant={emphasize ? "h2" : "h4"} sx={{
      color: emphasize ? green[500] : grey[600],
      textTransform: emphasize ? "uppercase" : "capitalize"
    }}>{title}</Typography>
    <TableContainer {...tableContainerProps}>
      <Table {...tableProps}>
        <TableBody>
          <TableRows rows={pairs} emphasize={emphasize} />
        </TableBody>
      </Table>
    </TableContainer>
  </React.Fragment>
}

export default Pairs;
