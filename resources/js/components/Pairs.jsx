import { Avatar, Box, Paper, Stack, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from "@mui/material";
import { green, grey } from "@mui/material/colors";
import SwapHorizIcon from '@mui/icons-material/SwapHoriz';
import React from "react";
import gravatar from "gravatar";

const cellWidth = "170px";
const unemphasizedCellWidth = "125px";
const smallCellWidth = "25px";

const smallAvatarSize = 24;
const normalAvatarSize = 32;

const CellText = function({emphasize = true, position = "left", ...props}) {
  if (typeof props.children === 'string') {
    const avatarSize = emphasize ? normalAvatarSize : smallAvatarSize;

    const textArray = props.children
      .split(',')
      .map((item) => item.trim());

    if(textArray.length > 1){
      const avatarProps = {
        variant: "rounded"
        , style: {
          backgroundColor: emphasize ? green[200] : grey[500]
        }
        , sx: {
          width: avatarSize
          , height: avatarSize
        }
        , alt: textArray[1]
        , src: gravatar.url(textArray[1])
      };

      const avatar = emphasize ? <Avatar {...avatarProps} /> : null;

      let content = <React.Fragment>
        {avatar}
        <span>{textArray[0]}</span>
      </React.Fragment>;

      if(position === 'left')
        content = <React.Fragment>
          <span>{textArray[0]}</span>
          {avatar}
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

const getCellWidth = function({small, emphasize}){
  if(emphasize){
    return small ? smallCellWidth : cellWidth;
  }else{
    return small ? smallCellWidth : unemphasizedCellWidth;
  }
}

const NormalTableCell = function({emphasize, position, ...props}) {
  return <TableCell {...props} sx={{borderBottom: "none"}}
    style={{
      ...props.style,
      borderBottom: 'none'
    }}>
    <Typography variant="p" sx={{
      width: getCellWidth({small: props.small, emphasize}),
      display: "inline-block",
      color: grey[500]
    }}>
      <CellText position={position} emphasize={emphasize}>{props.children}</CellText>
    </Typography>
  </TableCell>
}

const EmphasizedTableCell = function({emphasize, position, ...props}){
  return <TableCell {...props} sx={{borderBottom: "none"}}>
    <Typography variant="h3" sx={{
      color: green[200],
      textTransform: "capitalize",
      width: getCellWidth({small: props.small, emphasize}),
      display: "inline-block"
    }}>
      <CellText position={position} emphasize={emphasize}>{props.children}</CellText>
    </Typography>
  </TableCell>
}

const TableRows = function({rows, emphasize}){
  const CellComponent = emphasize ? EmphasizedTableCell : NormalTableCell;

  if(rows.length === 0)
    return <TableRow>
      <CellComponent align="center">
        <Stack direction="row" spacing={1}>
          <Typography>coming soon</Typography>
          <Avatar
            alt="soon"
            src="/world-pipe.gif"
            variant="rounded"
            sx={{ width: 24, height: 24, border: "2px solid #002e0c" }}
          />
        </Stack>
      </CellComponent>
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

const Pairs = function({title, width = "100%", pairs = [], emphasize = false}){
  const tableContainerProps = emphasize ?
    {
      // component: Paper,
      // elevation: 1
    } :
    {}

  const tableProps = emphasize ?
    {} :
    {
      size: "small"
    }

  return <Box sx={{ width }}>
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
  </Box>
}

export default Pairs;
