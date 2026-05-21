import { HydraAdmin, ResourceGuesser, hydraDataProvider } from "@api-platform/admin";
import React from "react";
import { AdminUI } from "react-admin";
import { SmartListGuesser } from "./SmartListGuesser";

const ENTRYPOINT = window.location.origin + "/_api/";

// useEmbedded: false — replace embedded relation objects with their @id strings so
// ReferenceField / ReferenceArrayField receive plain IRI strings, not full objects.
const dataProvider = hydraDataProvider({ entrypoint: ENTRYPOINT, useEmbedded: false });

/**
* Wraps AdminUI to inject SmartListGuesser into every auto-discovered ResourceGuesser.
*/
const SmartAdminUI = ({ children, ...props }: React.ComponentProps<typeof AdminUI>) => {
const smartChildren = React.Children.map(children, (child) => {
    if (React.isValidElement(child) && (child as React.ReactElement).type === ResourceGuesser) {
    return React.cloneElement(child as React.ReactElement, { list: SmartListGuesser });
    }
    return child;
});
return <AdminUI {...props}>{smartChildren}</AdminUI>;
};

export const App = () => (
<HydraAdmin entrypoint={ENTRYPOINT} dataProvider={dataProvider} admin={SmartAdminUI} />
);
