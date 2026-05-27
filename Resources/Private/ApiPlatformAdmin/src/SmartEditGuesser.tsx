import {EditGuesser, Introspecter} from "@api-platform/admin";
import type {Field} from "@api-platform/api-doc-parser";
import {useResourceContext} from "react-admin";
import {SmartInputGuesser} from "./SmartInputGuesser";

interface IntrospectedProps {
    writableFields: Field[];

    [key: string]: unknown;
}

const IntrospectedSmartEdit = ({writableFields, ...props}: IntrospectedProps) => (
    <EditGuesser {...props}>
        {writableFields.map((field) => (
            <SmartInputGuesser key={field.name} source={field.name} />
        ))}
    </EditGuesser>
);

export const SmartEditGuesser = (props: Record<string, unknown>) => {
    const resource = useResourceContext(props as { resource?: string });
    return (
        <Introspecter
            component={IntrospectedSmartEdit} resource={resource!} includeDeprecated={true}{...props} />
    );
};
