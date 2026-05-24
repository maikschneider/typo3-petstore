import { HydraAdmin, ResourceGuesser, hydraDataProvider } from "@api-platform/admin";
import React from "react";
import { AdminUI } from "react-admin";
import { SmartEditGuesser } from "./SmartEditGuesser";
import { SmartListGuesser } from "./SmartListGuesser";
import { SmartShowGuesser } from "./SmartShowGuesser";

const ENTRYPOINT = window.location.origin + document.getElementById('root')?.getAttribute('data-api-prefix');

// useEmbedded: false — replace embedded relation objects with their @id strings so
// ReferenceField / ReferenceArrayField receive plain IRI strings, not full objects.
const dataProvider = hydraDataProvider({ entrypoint: ENTRYPOINT, useEmbedded: false });

/**
* Wraps AdminUI to inject smart guessers into every auto-discovered ResourceGuesser.
*/
const SmartAdminUI = ({ children, ...props }: React.ComponentProps<typeof AdminUI>) => {
const smartChildren = React.Children.map(children, (child) => {
    if (React.isValidElement(child) && (child as React.ReactElement).type === ResourceGuesser) {
    return React.cloneElement(child as React.ReactElement, {
        list: SmartListGuesser,
        show: SmartShowGuesser,
        edit: SmartEditGuesser,
    });
    }
    return child;
});
return <AdminUI {...props}>{smartChildren}</AdminUI>;
};

export const App = () => (
<HydraAdmin entrypoint={ENTRYPOINT} dataProvider={dataProvider} admin={SmartAdminUI} />
);
